<?php

declare(strict_types=1);

namespace User\Presentation\Console\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use User\Domain\Service\UserService;

#[AsCommand(name: 'user:add')]
class AddUserCommand extends Command
{
    public function __construct(
        private readonly UserService $userService
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Creates a new user')
            ->addArgument(
                'username',
                InputArgument::REQUIRED,
                'Username'
            )
            ->addArgument(
                'email',
                InputArgument::REQUIRED,
                'Email'
            )
            ->addArgument(
                'password',
                InputArgument::REQUIRED,
                'Password'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $username = $input->getArgument('username');
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');

        $user = $this->userService->create($username, $email, $password);
        $this->userService->enable($user);

        $io->info(sprintf('Created User %s (%s) : #%s ', $username, $email, $user->getId()->toString()));

        return Command::SUCCESS;
    }
}
