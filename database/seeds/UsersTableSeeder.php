<?php

use Illuminate\Database\Seeder;
use App\Models\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //app 获取 faker 实例
        $faker = app(Faker\Generator::class);
        $avatars = [
            'http://larabbs.test/uploads/images/avatars/201908/14/1_1565753374_S3DSzmCFJ8.jpg',
            'http://larabbs.test/uploads/images/avatars/201908/14/1_1565753374_S3DSzmCFJ8.jpg',
            'http://larabbs.test/uploads/images/avatars/201908/14/1_1565753374_S3DSzmCFJ8.jpg',
            'http://larabbs.test/uploads/images/avatars/201908/14/1_1565753374_S3DSzmCFJ8.jpg',
            'http://larabbs.test/uploads/images/avatars/201908/14/1_1565753374_S3DSzmCFJ8.jpg',
            'http://larabbs.test/uploads/images/avatars/201908/14/1_1565753374_S3DSzmCFJ8.jpg',
        ];

        //生成数据集合
        $users = factory(User::class)
                    ->times(10)
                    ->make()
                    ->each(function ($user, $index) use ($faker, $avatars){
                        //从头像数组中随机取一个
                        $user->avatar = $faker->randomElement($avatars);
                    });

        //让隐藏字段可见，并将数据集合转换为数组
        $user_array = $users->makeVisible(['password','remember_token'])->toArray();

        //插入到数据中
        User::insert($user_array);

        //单独处理第一个用户
        $user = User::find(1);
        $user->name = 'zesai';
        $user->email = 'zesai@163.com';
        $user->avatar = 'http://larabbs.test/uploads/images/avatars/201908/14/1_1565753374_S3DSzmCFJ8.jpg';
        $user->save();

        // 初始化用户角色，将 1 号用户指派为『站长』
        $user->assignRole('Founder');

        // 将 2 号用户指派为『管理员』
        $user = User::find(2);
        $user->assignRole('Maintainer');
    }
}
