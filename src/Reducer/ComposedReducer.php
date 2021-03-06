<?php
declare(strict_types=1);

namespace Ctefan\Redux\Reducer;

use Ctefan\Redux\Action\ActionInterface;

/**
 * Each reducer of the ComposedReducer reduces the full state.
 */
class ComposedReducer
{
    /**
     * @var array<callable>
     */
    protected $reducers = [];

    /**
     * ComposedReducer constructor.
     *
     * @param array<callable> $reducers
     */
    public function __construct(array $reducers)
    {
        foreach ($reducers as $reducer) {
            $this->addReducer($reducer);
        }
    }

    /**
     * @param mixed $state
     * @param ActionInterface $action
     * @return mixed
     */
    public function __invoke($state, ActionInterface $action)
    {
        foreach ($this->getReducers() as $reducer) {
            $state = $reducer($state, $action);
        }
        return $state;
    }

    /**
     * @param callable $reducer
     */
    protected function addReducer(callable $reducer): void
    {
        $this->reducers[] = $reducer;
    }

    /**
     * @return array<callable>
     */
    protected function getReducers(): array
    {
        return $this->reducers;
    }
}