<?php

namespace App\Services\Workflow;

use App\Workflows\MyWorkflow;
use Workflow\WorkflowStub;

class WorkflowService
{
    public static function foo(): void
    {
        $workflow = WorkflowStub::make(MyWorkflow::class);
        var_dump($workflow);
        $workflow->start();
    }
}
