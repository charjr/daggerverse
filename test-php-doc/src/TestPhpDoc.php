<?php

declare(strict_types=1);

namespace DaggerModule;

use Dagger\{Container, Directory};
use Dagger\Attribute\{DaggerFunction, DaggerObject, Doc};

use function Dagger\dag;

#[DaggerObject]
#[Doc(<<<DOC
    Short description is the first line

    Long descriptions include any lines past that.
    So I expect to see this show up.
    DOC)]
class TestPhpDoc
{
    #[DaggerFunction]
    #[Doc('Returns a container that echoes whatever string argument is provided')]
    public function containerEcho(string $stringArg): Container
    {
        return dag()
            ->container()
            ->from('alpine:latest')
            ->withExec(['echo', $stringArg]);
    }

    #[DaggerFunction]
    #[Doc('Returns lines that match a pattern in the files of the provided Directory')]
    public function grepDir(
        #[Doc('The directory to search')]
        Directory $directoryArg,
        #[Doc('The pattern to search for')]
        string $pattern
    ): string {
        return dag()
            ->container()
            ->from('alpine:latest')
            ->withMountedDirectory('/mnt', $directoryArg)
            ->withWorkdir('/mnt')
            ->withExec(["grep", '-R', $pattern, '.'])
            ->stdout();
    }
}
