<?php
/**
 * Created by PhpStorm.
 * User: meetalodariya
 * Date: 02/01/20
 * Time: 9:25 AM
 */

namespace App\DataFixtures;

use App\Entity\MicroPost;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager){

        $this->loadMicropost($manager);
        $this->loadUsers($manager);
    }

    public function loadMicropost(ObjectManager $manager){
        for($i = 0 ; $i<10 ; $i++) {
            $micropost = new MicroPost();
            $micropost->setText("Some random text");
            $micropost->setDate(new \DateTime('2019-05-15'));
            $manager->persist($micropost);
        }
        $manager->flush();
    }

    public function loadUsers(ObjectManager $manager){
        $user = new User();
        $user->setEmail('johndoe@gmail.com');
        $user->setFullName('John Doe');
        $user->setUsername('johndoe1234');
        $user->setPassword($this->passwordEncoder->encodePassword($user  , 'johndoe123' ));
        $manager->persist($user);
        $manager->flush();
    }
}