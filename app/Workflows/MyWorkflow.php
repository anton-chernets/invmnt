<?php

namespace App\Workflows;

use Workflow\ActivityStub;
use Workflow\Workflow;

class MyWorkflow extends Workflow
{
    public function execute(): \Generator
    {
        return yield ActivityStub::make(MyActivity::class);
    }
}
