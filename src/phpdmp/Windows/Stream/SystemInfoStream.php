<?php

namespace phpdmp\Windows\Stream;

/*
Contains processor and operating system information.
    https://msdn.microsoft.com/en-us/library/windows/desktop/ms680396(v=vs.85).aspx
*/
class SystemInfoStream extends Stream
{
    public function __construct($streamData)
    {
        parent::__construct($streamData);

        $unpackFormat = [
            'vprocessorArchitecture',
            'vprocessorLevel',
            'vprocessorRevision',
            'CnumberOfProcessors',
            'CproductType',
            'VmajorVersion',
            'VminorVersion',
            'VbuildNumber',
            'VplatformId',
            'VCSDVersionRVA',
            'vsuiteMask',
            'vreserved',
            'V3vendorId',
            'VversionInformation',
            'VfeatureInformation',
            'VamdExtendedCPUFeatures',
        ];

        foreach (unpack(implode('/', $unpackFormat), $streamData) as $variable => $value) {
            $this->{$variable} = $value;
        }
    }

    public function getMajorVersion()
    {
        return $this->majorVersion;
    }
    public function getMinorVersion()
    {
        return $this->minorVersion;
    }
    public function getBuildNumber()
    {
        return $this->buildNumber;
    }
}
