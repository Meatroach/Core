<?php

namespace OpenTribes\Core\Silex\Repository;


interface WritableRepository {
    public function sync();
    public function truncate();
}