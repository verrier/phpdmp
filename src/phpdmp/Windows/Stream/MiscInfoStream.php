<?php

namespace phpdmp\Windows\Stream;

use phpdmp\Windows\Enumeration\MiniDumpMiscInfoFlags;

class MiscInfoStream extends Stream
{
    private $miscInfoStreamType;
    public function __construct($streamData)
    {
        parent::__construct($streamData);

        //MINIDUMP_MISC_INFO
        $unpackFormat = [
            'VsizeOfInfo',
            'Vflags',
        ];

        //Go ahead and unpack this small amount of data so we can use it below
        extract(unpack(implode('/', $unpackFormat), $streamData));
        $this->sizeOfInfo = $sizeOfInfo;
        $this->flags = $flags;

        if ($this->hasFlag(MiniDumpMiscInfoFlags::MINIDUMP_MISC1_PROCESS_ID)) {
            $unpackFormat = array_merge(
                $unpackFormat,
                [
                  'VprocessId',
                ]
            );
        }
        if ($this->hasFlag(MiniDumpMiscInfoFlags::MINIDUMP_MISC1_PROCESS_TIMES)) {
            $unpackFormat = array_merge(
                $unpackFormat,
                [
                  'VprocessCreateTime',
                  'VprocessUserTime',
                  'VprocessKernelTime',
                ]
            );
        }
        if ($this->hasFlag(MiniDumpMiscInfoFlags::MINIDUMP_MISC1_PROCESSOR_POWER_INFO)) {
            $unpackFormat = array_merge(
                $unpackFormat,
                [
                    'VprocessorMaxMhz',
                    'VprocessorCurrentMhz',
                    'VprocessorMhzLimit',
                    'VprocessorMaxIdleState',
                    'VprocessorCurrentIdleState',
                ]
            );
        }
        if ($this->hasFlag(MiniDumpMiscInfoFlags::MINIDUMP_MISC3_PROCESS_INTEGRITY)) {
            $unpackFormat = array_merge(
                $unpackFormat,
                [
                    'VprocessIntegrityLevel',  //https://crashpad.chromium.org/doxygen/structMINIDUMP__MISC__INFO__3.html
                ]
            );
        }
        if ($this->hasFlag(MiniDumpMiscInfoFlags::MINIDUMP_MISC3_PROCESS_EXECUTE_FLAGS)) {
            $unpackFormat = array_merge(
                $unpackFormat,
                [
                    'VprocessExecuteFlags',
                ]
            );
        }
        if ($this->hasFlag(MiniDumpMiscInfoFlags::MINIDUMP_MISC3_PROTECTED_PROCESS)) {
            $unpackFormat = array_merge(
                $unpackFormat,
                [
                    'VprotectedProcess',
                ]
            );
        }
        if ($this->hasFlag(MiniDumpMiscInfoFlags::MINIDUMP_MISC3_TIMEZONE)) {
            $unpackFormat = array_merge(
                $unpackFormat,
                [
                    'VtimeZoneId',
                    //TIME_ZONE_INFORMATION
                    //  https://msdn.microsoft.com/en-us/library/windows/desktop/ms725481(v=vs.85).aspx
                    'VtimeZoneBias',
                    'C64standardName',

                    //standardDate: SYSTEMTIME
                    // https://msdn.microsoft.com/en-us/library/windows/desktop/ms724950(v=vs.85).aspx
                    'vstandardDateYear',
                    'vstandardDateMonth',
                    'vstandardDateDayOfWeek',
                    'vstandardDateDay',
                    'vstandardDateHour',
                    'vstandardDateMinute',
                    'vstandardDateSecond',
                    'vstandardDateMilliseconds',

                    'VstandardBias',
                    'C64daylightName',

                    //daylightDate: SYSTEMTIME
                    // https://msdn.microsoft.com/en-us/library/windows/desktop/ms724950(v=vs.85).aspx
                    'vdaylightDateYear',
                    'vdaylightDateMonth',
                    'vdaylightDateDayOfWeek',
                    'vdaylightDateDay',
                    'vdaylightDateHour',
                    'vdaylightDateMinute',
                    'vdaylightDateSecond',
                    'vdaylightDateMilliseconds',
                    'VdaylightBias',
                ]
            );
        }
        if ($this->hasFlag(MiniDumpMiscInfoFlags::MINIDUMP_MISC4_BUILDSTRING)) {
            $unpackFormat = array_merge(
                $unpackFormat,
                [
                    'C520buildString', //Linux : 4096  - Windows : 260 ???  (*2 for wchar)
                    'C80dbgBldStr'
                ]
            );
        }
        if ($this->hasFlag(MiniDumpMiscInfoFlags::MINIDUMP_MISC5_PROCESS_COOKIE)) {
            $unpackFormat = array_merge(
                $unpackFormat,
                [
                    //TODO: XSTATE_CONFIG_FEATURE_MSC_INFO XStateData and ULONG32 ProcessCookie
                ]
            );
        }

        foreach (unpack(implode('/', $unpackFormat), $streamData) as $field => $value) {
            //Attempt to handle the multiple fields defined above
            if (preg_match('/(.*?)\d+$/', $field, $matches)) {
                $this->{$matches[1]} .= chr($value);
            } else {
                $this->$field = $value;
            }
        }

        //Clean up some strings that are wchar
        $this->standardName = trim(iconv('UTF-16LE', 'UTF-8', $this->standardName));
        $this->daylightName = trim(iconv('UTF-16LE', 'UTF-8', $this->daylightName));
        $this->buildString = trim(iconv('UTF-16LE', 'UTF-8', $this->buildString));
        $this->dbgBldStr = trim(iconv('UTF-16LE', 'UTF-8', $this->dbgBldStr));
    }

    public function hasFlag($flag)
    {
        return ($this->flags & $flag) === $flag;
    }

    public function getBuildString()
    {
        return $this->buildString;
    }
}
