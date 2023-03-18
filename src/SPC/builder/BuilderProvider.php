<?php

declare(strict_types=1);

namespace SPC\builder;

use SPC\builder\linux\LinuxBuilder;
use SPC\builder\macos\MacOSBuilder;
use SPC\builder\windows\WindowsBuilder;
use SPC\exception\RuntimeException;
use Symfony\Component\Console\Input\InputInterface;

/**
 * 用于生成对应系统环境的 Builder 对象的类
 */
class BuilderProvider
{
    /**
     * @throws RuntimeException
     */
    public static function makeBuilderByInput(InputInterface $input): BuilderBase
    {
        return match (PHP_OS_FAMILY) {
            // 'Windows' => new WindowsBuilder(
            //   binary_sdk_dir: $input->getOption('with-sdk-binary-dir'),
            //    vs_ver: $input->getOption('vs-ver'),
            //    arch: $input->getOption('arch'),
            // ),
            'Darwin' => new MacOSBuilder(
                cc: $input->getOption('cc'),
                cxx: $input->getOption('cxx'),
                arch: $input->getOption('arch'),
            ),
            // 'Linux' => new LinuxBuilder(
            //    cc: $input->getOption('cc'),
            //    cxx: $input->getOption('cxx'),
            //    arch: $input->getOption('arch'),
            // ),
            default => throw new RuntimeException('Current OS is not supported yet'),
        };
    }
}
