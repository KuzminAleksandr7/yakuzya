<?php

namespace Database\Factories;

use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    private array $users = [];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $locale = 'uk_UA';
        $gender = collect(['male', 'female'])->random();
        $year = fake()->year();

        $firstname = fake($locale)->firstName($gender);
        $lastname = fake($locale)->lastName($gender);

        $sluged_fn = Str::slug($firstname);
        $sluged_ln = Str::slug($lastname);

        $mail = collect(['@gmail.com', '@abz.agency', '@yahoo.com', '@hotmail.com'])->random();
        $base_email = Str::lower("{$sluged_fn}.{$sluged_ln}{$year}{$mail}");

        $unique_email = $base_email;
        while (isset($this->users[$unique_email])) {
            $year--;
            $unique_email = Str::lower("{$sluged_fn}.{$sluged_ln}{$year}{$mail}");
        }

        $this->users[$unique_email] = [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $unique_email,
            'phone' => '+380' . mt_rand(100000000, 999999999), // поле унікальне, але ймовірність досить низька, тому так )
            'photo' => null,
            'position_id' => Position::inRandomOrder()->first()->id,

            'email_verified_at' => now(),
            'password' => Hash::make(Str::random()),
            'remember_token' => Str::random(10),
            'updated_at' => now(),
            'created_at' => fake()->dateTimeBetween('-15 years'),
        ];

        // Можна було б зробити набагато простіше, але тоді б емейл не співпадав з ім'ям/прізвищем користувача(по ТЗ - дані максимальні до реальних)
        // В наслідок, перебирання масиву $this->users для уніфікації пошти витрачаєься багато прани
        //  return [
        //      'firstname' => $firstname,
        //      'lastname' => $lastname,
        //      'email' => fake($locale)->unique()->safeEmailDomain(),
        //      'phone' => '+380' . sprintf('%09d', mt_rand(100000000, 999999999)),
        //      'image' => null,
        //      'position_id' => Position::inRandomOrder()->first()->id,
        //      'email_verified_at' => now(),
        //      'password' => Hash::make(Str::random()),
        //      'remember_token' => Str::random(10),
        //  ];

        return $this->users[$unique_email];
    }
}
