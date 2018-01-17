<?php

namespace DigipolisGent\Github\Core\Command;

use Github\Client;
use Github\Exception\TwoFactorAuthenticationRequiredException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;

/**
 * Abstract base class for commands that require the Github Team service.
 *
 * @package DigipolisGent\Github\Core\Command
 */
abstract class AbstractCommand extends Command
{
    /**
     * The Github Client to get the repositories from.
     *
     * @var Client
     */
    protected $client;

    /**
     * Add options to login to Github.
     */
    protected function configureLogin()
    {
        $this
            ->addOption(
                'access-token',
                'u',
                InputOption::VALUE_REQUIRED,
                'Github personal access token (https://github.com/settings/tokens)'
            )
        ;
    }

    /**
     * Add Github Team name option.
     */
    protected function configureTeamName()
    {
        $this
            ->addArgument(
                'team',
                InputArgument::REQUIRED,
                'Github Team name to get the repositories for'
            )
        ;
    }

    /**
     * Get the Github client to use in the services.
     *
     * @return Client
     */
    protected function getGithubClient()
    {
        if (null === $this->client) {
            $this->client = new Client();
        }

        return $this->client;
    }

    /**
     * Authenticate the client.
     *
     * @param InputInterface $input
     */
    protected function authenticate(InputInterface $input)
    {
        try {
            $this->getGithubClient()->authenticate(
                $input->getOption('access-token'),
                '',
                Client::AUTH_HTTP_PASSWORD
            );
        } catch (TwoFactorAuthenticationRequiredException $e) {
            echo sprintf('Two factor authentication of type %s is required for fucks sake.', $e->getType());
        }
    }
}
