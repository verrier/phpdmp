<?php

namespace phpdmp\Windows\Enumeration;

abstract class MiniDumpMiscInfoFlags
{
    const MINIDUMP_MISC1_PROCESS_ID            = 0x00000001;
    const MINIDUMP_MISC1_PROCESS_TIMES         = 0x00000002;
    const MINIDUMP_MISC1_PROCESSOR_POWER_INFO  = 0x00000004;
    const MINIDUMP_MISC3_PROCESS_INTEGRITY     = 0x00000010;
    const MINIDUMP_MISC3_PROCESS_EXECUTE_FLAGS = 0x00000020;
    const MINIDUMP_MISC3_TIMEZONE              = 0x00000040;
    const MINIDUMP_MISC3_PROTECTED_PROCESS     = 0x00000080;
    const MINIDUMP_MISC4_BUILDSTRING           = 0x00000100;
    const MINIDUMP_MISC5_PROCESS_COOKIE        = 0x00000200;
}
