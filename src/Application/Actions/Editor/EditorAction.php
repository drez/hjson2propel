<?php



namespace App\Application\Actions\Editor;

use App\Application\Actions\Action;
use App\Domain\Editor\Editor;
use Psr\Log\LoggerInterface;

abstract class EditorAction extends Action
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @param LoggerInterface $logger
     * @param UserRepository  $userRepository
     */
    public function __construct(LoggerInterface $logger, Editor $Editor)
    {
        parent::__construct($logger);
        $this->Editor = new Editor();
    }

    public function show()
    {
    }
}
