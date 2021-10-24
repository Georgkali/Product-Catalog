<?php

namespace App;

use App\Repositories\MsqlUsersRepositoryImplementation;

class Container
{
    private array $repositories = [];

    public function addRepository(string $repoName, object $repo)
    {
        $this->repositories[$repoName] = $repo;
    }

    public function getRepository(string $repoName)
    {
        return $this->repositories[$repoName];
    }


    public function getRepositories(): array
    {
        return $this->repositories;
    }

}


