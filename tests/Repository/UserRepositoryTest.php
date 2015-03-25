<?php
namespace OpenTribes\Core\Test\Repository;

use OpenTribes\Core\Silex\Repository;
use OpenTribes\Core\Test\SilexApplicationTest;

class UserRepositoryTest extends SilexApplicationTest {
    /**
     * @var Repository\DBALUserRepository
     */
    private $repository;

    public function setUp(){
        $app = $this->getApplication();
        /**
         * @var Repository\DBALUserRepository $repository
         */
        $repository = $app[Repository::USER];

        $this->repository = $repository;
    }
    public function tearDown(){
        $this->repository->truncate();

    }

    private function createDummyUser(){
        $userId = $this->repository->getUniqueId();
        $user = $this->repository->create($userId,'UserRepositoryTestUser','12345','test@test.com');
        $this->repository->add($user);
        $this->repository->sync();
        return $user;
    }

    public function testCanCreateNewUser(){
        $user = $this->createDummyUser();
        $newUser = $this->repository->findByUsername($user->getUsername());
        $this->assertEquals($user,$newUser);
    }
    public function testCanModifyUser(){
        $user = $this->createDummyUser();

        $user->setEmail('test2@test.com');
        $user->setPasswordHash('asd');

        $this->repository->modify($user);
        $this->repository->sync();

        $modifiedUser = $this->repository->findByUsername($user->getUsername());
        $this->assertEquals($user,$modifiedUser);
    }
    public function testCanDeleteUser(){
        $user = $this->createDummyUser();
        $this->repository->delete($user);
        $this->repository->sync();
        $deletedUser = $this->repository->findByUsername($user->getUsername());
        $this->assertNull($deletedUser);
    }
}
