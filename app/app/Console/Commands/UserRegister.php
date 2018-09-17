<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Validator;

class UserRegister extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:register';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->register($this->getData());
    }

    /**
     * Получение данных для регистрации пользователя через консоль
     *
     * @return mixed
     */
    private function getData()
    {
        $data['name'] = $this->ask('Введите логин пользователя');
        $data['email'] = $this->ask('Введите email пользователя');
        $data['password'] = $this->secret('Введите пароль пользователя');
        $data['password'] = bcrypt($data['password']);

        return $data;
    }

    /**
     * Регистрация пользователя
     *
     * @param $data
     */
    private function register($data)
    {
        $validator = Validator::make($data, [
            'name'     => 'required|min:3',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6'
        ], [
            'name.min'     => 'Имя должно быть больше 3-х символов',
            'email.email'  => 'Проверьте правильность email',
            'email.unique' => 'Данный email уже зарегистрирован',
            'password.min' => 'Пароль должен быть длиннее 6-ти символов'
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors()->first());
        }
        $user = new User();
        $user->fill($data);

        if (!$user->save()) {
            return $this->error('Ошибка сохранения пользователя');
        }

        return $this->info('Пользователь успешно зарегистрирован');
    }
}
