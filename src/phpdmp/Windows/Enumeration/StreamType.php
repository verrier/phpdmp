<?php

namespace phpdmp\Windows\Enumeration;

abstract class StreamType
{
    const UnusedStream               = 0;
    const ReservedStream0            = 1;
    const ReservedStream1            = 2;
    const ThreadListStream           = 3;
    const ModuleListStream           = 4;
    const MemoryListStream           = 5;
    const ExceptionStream            = 6;
    const SystemInfoStream           = 7;
    const ThreadExListStream         = 8;
    const Memory64ListStream         = 9;
    const CommentStreamA             = 10;
    const CommentStreamW             = 11;
    const HandleDataStream           = 12;
    const FunctionTableStream        = 13;
    const UnloadedModuleListStream   = 14;
    const MiscInfoStream             = 15;
    const MemoryInfoListStream       = 16;
    const ThreadInfoListStream       = 17;
    const HandleOperationListStream  = 18;

    //Added in windows 10 or later? Undocumented?
    //https://github.com/tpn/winsdk-10/blob/38ad81285f0adf5f390e5465967302dd84913ed2/Include/10.0.10240.0/um/minidumpapiset.h
    const TokenStream                = 19;
    const JavaScriptDataStream       = 20;
    const SystemMemoryInfoStream     = 21;
    const ProcessVmCountersStream    = 22;

    const LastReservedStream         = 0xfff;

    public static function getName($integer)
    {
        $oClass = new \ReflectionClass(__CLASS__);
        foreach ($oClass->getConstants() as $name => $value) {
            if($value == $integer){
                return $name;
            }
        }
        return false;
    }
}
