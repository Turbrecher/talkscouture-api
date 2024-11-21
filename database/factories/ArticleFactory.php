<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ArticleFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sections = ["The Thought", "Dear Fashion", "Mucho más que anuncios"];

        $photos = [
            "img1.jpg",
            "img2.jpg",
            "img3.jpg",
            "img4.jpg",
        ];

        $content = "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ultrices urna sit amet dui cursus, a elementum magna dignissim. Nam lorem dolor, ultricies et blandit in, facilisis quis mi. Fusce pulvinar mi a ipsum dignissim, quis condimentum risus egestas. Cras eget faucibus magna. Sed aliquet nulla nisi, sit amet tristique mauris sagittis ut. Integer mattis aliquam purus, interdum ultrices enim elementum in. Suspendisse volutpat ultricies urna, at fermentum arcu viverra et. Integer id consectetur diam, at molestie nulla. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ultrices urna sit amet dui cursus, a elementum magna dignissim. Nam lorem dolor, ultricies et blandit in, facilisis quis mi. Fusce pulvinar mi a ipsum dignissim, quis condimentum risus egestas. Cras eget faucibus magna. Sed aliquet nulla nisi, sit amet tristique mauris sagittis ut. Integer mattis aliquam purus, interdum ultrices enim elementum in. Suspendisse volutpat ultricies urna, at fermentum arcu viverra et. Integer id consectetur diam, at molestie nulla.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ultrices urna sit amet dui cursus, a elementum magna dignissim. Nam lorem dolor, ultricies et blandit in, facilisis quis mi. Fusce pulvinar mi a ipsum dignissim, quis condimentum risus egestas. Cras eget faucibus magna. Sed aliquet nulla nisi, sit amet tristique mauris sagittis ut. Integer mattis aliquam purus, interdum ultrices enim elementum in. Suspendisse volutpat ultricies urna, at fermentum arcu viverra et. Integer id consectetur diam, at molestie nulla. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ultrices urna sit amet dui cursus, a elementum magna dignissim. Nam lorem dolor, ultricies et blandit in, facilisis quis mi. Fusce pulvinar mi a ipsum dignissim, quis condimentum risus egestas. Cras eget faucibus magna. Sed aliquet nulla nisi, sit amet tristique mauris sagittis ut. Integer mattis aliquam purus, interdum ultrices enim elementum in. Suspendisse volutpat ultricies urna, at fermentum arcu viverra et. Integer id consectetur diam, at molestie nulla. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ultrices urna sit amet dui cursus, a elementum magna dignissim. Nam lorem dolor, ultricies et blandit in, facilisis quis mi. Fusce pulvinar mi a ipsum dignissim, quis condimentum risus egestas. Cras eget faucibus magna. Sed aliquet nulla nisi, sit amet tristique mauris sagittis ut. Integer mattis aliquam purus, interdum ultrices enim elementum in. Suspendisse volutpat ultricies urna, at fermentum arcu viverra et. Integer id consectetur diam, at molestie nulla. </p>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ultrices urna sit amet dui cursus, a elementum magna dignissim. Nam lorem dolor, ultricies et blandit in, facilisis quis mi. Fusce pulvinar mi a ipsum dignissim, quis condimentum risus egestas. Cras eget faucibus magna. Sed aliquet nulla nisi, sit amet tristique mauris sagittis ut. Integer mattis aliquam purus, interdum ultrices enim elementum in. Suspendisse volutpat ultricies urna, at fermentum arcu viverra et. Integer id consectetur diam, at molestie nulla. </p>";

        return [
            'title' => fake()->words(5, true),
            'content' => $content,
            'date' => fake()->date("Y.m.d"),
            'time' => fake()->time(),
            'photo' => $photos[rand(0,count($photos)-1)],
            'writer_id' => rand(1, 10),
            'section' => $sections[rand(0, 2)],
            'description' => fake()->words(49, true),
            'readTime' => rand(1, 10)

        ];
    }
}
