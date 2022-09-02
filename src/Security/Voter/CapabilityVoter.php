<?php

namespace Sword\SwordBundle\Security\Voter;

use Sword\SwordBundle\Security\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

final class CapabilityVoter implements VoterInterface
{
    public function vote(TokenInterface $token, $subject, array $attributes): int
    {
        $result = self::ACCESS_ABSTAIN;

        /** @var User $user */
        $user = $token->getUser() instanceof User ? $token->getUser() : null;

        if (!$user instanceof User) {
            return $result;
        }

        foreach ($attributes as $attribute) {
            $result = self::ACCESS_DENIED;

            if (\in_array($attribute, $user->getCapabilities(), true)) {
                return self::ACCESS_GRANTED;
            }
        }

        return $result;
    }
}
