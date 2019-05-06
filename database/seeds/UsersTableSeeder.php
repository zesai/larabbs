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
            'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/s5ehp11z6s.png',
            'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/Lhd1SHqu86.png',
            'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/LOnMrqbHJn.png',
            'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/xAuDMxteQy.png',
            'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/ZqM7iaP4CR.png',
            'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/NDnzMutoxX.png',
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
        $user->avatar = 'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/ZqM7iaP4CR.png';
        $user->save();
    }
}
