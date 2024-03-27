<?php

namespace App\Security\Voter;

use App\Entity\User;
use App\Entity\Recruiter;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class RecruiterVoter extends Voter
{
    public const EDIT = 'RECRUITER_EDIT';
    public const VIEW = 'RECRUITER_VIEW';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::EDIT, self::VIEW])
            && $subject instanceof Recruiter;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        if (!$subject instanceof Recruiter){
            return false;
        }

        switch ($attribute) {
            case self::EDIT:
                return $subject->getUser()->getId() === $user->getId();
                break;
            case self::VIEW:
                // logic to determine if the user can VIEW
                // return true or false
                break;
        }

        return false;
    }
}
