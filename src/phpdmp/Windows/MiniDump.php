<?php

namespace phpdmp\Windows;

use phpdmp\Windows\Stream;

class MiniDump
{
    //Dump file attributes
    private $signature;
    private $version;
    private $checksum;
    private $timestamp;

    private $steams = [];

    public function loadData($fileContents)
    {
        //Simple sanity check first before we attempt to do any parsing
        if (substr($fileContents, 0, 4) !== 'MDMP') {
            throw new \InvalidArgumentException("DMP file contents are not a valid windows dump file");
        }

        //Parse out the header attributes for the MDMP file format
        //  https://msdn.microsoft.com/en-us/library/windows/desktop/ms680378(v=vs.85).aspx
        extract(unpack('Nsignature/Vversion/VnumberOfStreams/VstreamDirectoryRVA/Vchecksum/Vtimestamp/Vreserved/Jflags', $fileContents));

        //Handle the minidump attributes that we want to expose
        /*
        //Build up a string based signature instead of the ULONG32
        $this->signature = array_reduce(unpack("C*", pack("N", $signature)), function($c, $i) {
            return $c . chr($i);
        });
        */
        $this->signature = $signature;
        $this->version = $version;
        $this->checksum = $checksum;
        $this->timestamp = $timestamp;

        //Parse our flags
        $this->flags = $flags;

        //Create our Streams and StreamDirectory
        $streamDirectoryData = unpack("V" . $numberOfStreams * 3, substr($fileContents, $streamDirectoryRVA));
        $streams = array_chunk($streamDirectoryData, 3);
        foreach ($streams as $streamData) {
            //https://msdn.microsoft.com/en-us/library/windows/desktop/ms680365(v=vs.85).aspx
            // 0 = Stream Type
            // 1 = Data Size
            // 2 = RVA
            $name = Enumeration\StreamType::getName($streamData[0]);
            if ($name) {
                //Variable loaded classes don't inherit current namespace so we must fully qualify it
                $name = 'phpdmp\\Windows\\Stream\\' . $name;
                $this->streams[] = new $name(substr($fileContents, $streamData[2], $streamData[1]));
            } else {
                echo "Unknown stream for type: {$streamData[0]}";
            }
        }

        //Return a reference for chaining
        return $this;
    }

    public function getSignature()
    {
        return $this->signature;
    }
    public function getVersion()
    {
        return $this->version;
    }
    public function getChecksum()
    {
        return $this->checksum;
    }
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    public function hasFlag(int $flag)
    {
        return (bool)($this->flags & $flag);
    }

    public function getStreamDirectory()
    {
        return $this->streamDirectory;
    }
    public function getStream($streamType)
    {
        foreach ($this->streams as $stream) {
            $name = 'phpdmp\\Windows\\Stream\\' . Enumeration\StreamType::getName($streamType);
            if ($stream instanceof $name) {
                return $stream;
            }
        }
    }
}
