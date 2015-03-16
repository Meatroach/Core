<?php
namespace OpenTribes\Core\Test\Repository;


use OpenTribes\Core\Entity\UserEntity;
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

    private function createDummyUser(){
        $userId = $this->repository->getUniqueId();
        $user = $this->repository->create($userId,'UserRepositoryTestUser','12345','test@test.com');
        $this->repository->add($user);
        $this->repository->sync();
        return $user;
    }
    private function deleteUser(UserEntity $user){
        $this->repository->delete($user);
        $this->repository->sync();
    }
    public function testCanCreateNewUser(){

        $user = $this->createDummyUser();


        $newUser = $this->repository->findByUsername('UserRepositoryTestUser');
        $this->assertEquals($user,$newUser);
        $this->deleteUser($user);
    }
}
