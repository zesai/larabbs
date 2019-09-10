<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CalculateActiveUser extends Command
{
    /**
     * 供我们调用的命令.
     *
     * @var string
     */
    protected $signature = 'larabbs:calculate-active-user';

    /**
     * 命令的描述.
     *
     * @var string
     */
    protected $description = '生成活跃用户';

    /**
     * 最终执行的方法.
     *
     * @return mixed
     */
    public function handle(User $user)
    {
        // 可以在命令行打印信息
        $this->info('开始计算...');

        $user->calculateAndCacheActiveUsers();

        $this->info('成功生成！');
    }
}
