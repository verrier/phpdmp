<?php

namespace phpdmp\Windows\Enumeration;

abstract class MiniDumpType
{
    const MiniDumpNormal                          = 0x00000000;
    const MiniDumpWithDataSegs                    = 0x00000001;
    const MiniDumpWithFullMemory                  = 0x00000002;
    const MiniDumpWithHandleData                  = 0x00000004;
    const MiniDumpFilterMemory                    = 0x00000008;
    const MiniDumpScanMemory                      = 0x00000010;
    const MiniDumpWithUnloadedModules             = 0x00000020;
    const MiniDumpWithIndirectlyReferencedMemory  = 0x00000040;
    const MiniDumpFilterModulePaths               = 0x00000080;
    const MiniDumpWithProcessThreadData           = 0x00000100;
    const MiniDumpWithPrivateReadWriteMemory      = 0x00000200;
    const MiniDumpWithoutOptionalData             = 0x00000400;
    const MiniDumpWithFullMemoryInfo              = 0x00000800;
    const MiniDumpWithThreadInfo                  = 0x00001000;
    const MiniDumpWithCodeSegs                    = 0x00002000;
    const MiniDumpWithoutAuxiliaryState           = 0x00004000;
    const MiniDumpWithFullAuxiliaryState          = 0x00008000;
    const MiniDumpWithPrivateWriteCopyMemory      = 0x00010000;
    const MiniDumpIgnoreInaccessibleMemory        = 0x00020000;
    const MiniDumpWithTokenInformation            = 0x00040000;
    const MiniDumpWithModuleHeaders               = 0x00080000;
    const MiniDumpFilterTriage                    = 0x00100000;
    const MiniDumpValidTypeFlags                  = 0x001ffff;
}
