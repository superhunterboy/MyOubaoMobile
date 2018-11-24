<?php
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * 生成公共下拉框静态json数据或html文件，使用该命令时，需要切换paths.php中的路径定义为具体路径，不能用变量
 */
class TestQueuePushCommand extends Command {
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'queue:push-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test push queue.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    public function fire()
    {
        Queue::push('TestQueue',['TestQueueDate' => Carbon::now()->toDateTimeString()]);
    }
}