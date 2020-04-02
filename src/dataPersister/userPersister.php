<?php


namespace App\dataPersister;


use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class userPersister implements DataPersisterInterface
{
    /**
     * @var EntityManagerInterface
     * @var UserPasswordEncoderInterface
     */
    private $em;
    private $encoder;

    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $encoder) {
        $this->em = $em;
        $this->encoder = $encoder;
    }

    /**
     * @inheritDoc
     */
    public function supports($data): bool
    {
        return $data instanceof User;
    }

    /**
     * @inheritDoc
     */
    public function persist($data)
    {
        // TODO: Implement persist() method.
        $plainPassword = $data->getPassword();
        $encodedPassword = password_hash($plainPassword, PASSWORD_BCRYPT);
        $data->setPassword($encodedPassword);

        $this->em->persist($data);
        $this->em->flush();
    }

    /**
     * @inheritDoc
     */
    public function remove($data)
    {
        // TODO: Implement remove() method.
    }
}