<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Phrase>
 */
class PhraseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'phrase' => '<p>"La moda no es algo que sólo existe en <span class="bold">vestimenta</span>. La moda es en el <span
                class="bold">cielo</span>, en la <span class="bold">calle</span>, la moda tiene que ver
            con <span class="bold">ideas</span>, la <span class="bold">forma en la que vivimos</span>, lo que <span
                class="bold">está sucediendo</span>."</p>
        <p class="italic">-Coco Chanel</p>'
        ];
    }
}
