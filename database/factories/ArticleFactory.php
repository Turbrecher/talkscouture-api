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
            "https://audaces.com/wp-content/uploads/2022/03/estilos-de-moda.webp",
            "https://img.freepik.com/vector-gratis/coleccion-bocetos-modelos-moda_23-2148223286.jpg",
            "https://i1.wp.com/moccamagazine.es/wp-content/uploads/2021/10/0_FotoPrincipal.jpeg?fit=600%2C435",
            "https://static.eldiario.es/clip/a169422c-b292-4c46-9a1d-082f46b9220e_16-9-discover-aspect-ratio_default_0.jpg",
            "https://imagenes.elpais.com/resizer/v2/XCTB5ENE5NFSLMP4MDGQWUQMSQ.jpg?auth=ec6931cf19ff2a002171e9fcb8b117815bc8558f007068f6d1398de75e3b49bf&width=1200",
            "https://media.es.wired.com/photos/650b2a2e72d73ca3bd5ef0cc/16:9/w_2560%2Cc_limit/Business-OpenAI-Dall-E-3-heart.jpg",
            "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSbPvDW8gBfklrVaTSSY2hp6mRtTOqMrKKYWg&s",
            "https://bnetcmsus-a.akamaihd.net/cms/content_entry_media/7WXVESTYNJTE1724701410514.png",
            "https://cdn.hobbyconsolas.com/sites/navi.axelspringer.es/public/media/image/2022/04/world-warcraft-classic-wrath-lich-king-2678433.jpg?tf=3840x",
            "https://www.publico.es/uploads/2024/08/02/66ad255e90cdc.jpeg",
            "https://edatv.news/filesedc/uploads/image/post/foto-de-ruben-gisbert-participando-en-un-programa-de-television_1600_1067.webp",
            "https://static.eldiario.es/clip/f991b5cc-b9e5-4b6f-b1fe-244c5cc45931_16-9-discover-aspect-ratio_default_0.jpg",
            "https://s03.s3c.es/imag/_v0/1200x655/2/3/d/carmen-iker.jpg"
        ];

        $content = "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ultrices urna sit amet dui cursus, a elementum magna dignissim. Nam lorem dolor, ultricies et blandit in, facilisis quis mi. Fusce pulvinar mi a ipsum dignissim, quis condimentum risus egestas. Cras eget faucibus magna. Sed aliquet nulla nisi, sit amet tristique mauris sagittis ut. Integer mattis aliquam purus, interdum ultrices enim elementum in. Suspendisse volutpat ultricies urna, at fermentum arcu viverra et. Integer id consectetur diam, at molestie nulla. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ultrices urna sit amet dui cursus, a elementum magna dignissim. Nam lorem dolor, ultricies et blandit in, facilisis quis mi. Fusce pulvinar mi a ipsum dignissim, quis condimentum risus egestas. Cras eget faucibus magna. Sed aliquet nulla nisi, sit amet tristique mauris sagittis ut. Integer mattis aliquam purus, interdum ultrices enim elementum in. Suspendisse volutpat ultricies urna, at fermentum arcu viverra et. Integer id consectetur diam, at molestie nulla.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ultrices urna sit amet dui cursus, a elementum magna dignissim. Nam lorem dolor, ultricies et blandit in, facilisis quis mi. Fusce pulvinar mi a ipsum dignissim, quis condimentum risus egestas. Cras eget faucibus magna. Sed aliquet nulla nisi, sit amet tristique mauris sagittis ut. Integer mattis aliquam purus, interdum ultrices enim elementum in. Suspendisse volutpat ultricies urna, at fermentum arcu viverra et. Integer id consectetur diam, at molestie nulla. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ultrices urna sit amet dui cursus, a elementum magna dignissim. Nam lorem dolor, ultricies et blandit in, facilisis quis mi. Fusce pulvinar mi a ipsum dignissim, quis condimentum risus egestas. Cras eget faucibus magna. Sed aliquet nulla nisi, sit amet tristique mauris sagittis ut. Integer mattis aliquam purus, interdum ultrices enim elementum in. Suspendisse volutpat ultricies urna, at fermentum arcu viverra et. Integer id consectetur diam, at molestie nulla. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ultrices urna sit amet dui cursus, a elementum magna dignissim. Nam lorem dolor, ultricies et blandit in, facilisis quis mi. Fusce pulvinar mi a ipsum dignissim, quis condimentum risus egestas. Cras eget faucibus magna. Sed aliquet nulla nisi, sit amet tristique mauris sagittis ut. Integer mattis aliquam purus, interdum ultrices enim elementum in. Suspendisse volutpat ultricies urna, at fermentum arcu viverra et. Integer id consectetur diam, at molestie nulla. </p>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ultrices urna sit amet dui cursus, a elementum magna dignissim. Nam lorem dolor, ultricies et blandit in, facilisis quis mi. Fusce pulvinar mi a ipsum dignissim, quis condimentum risus egestas. Cras eget faucibus magna. Sed aliquet nulla nisi, sit amet tristique mauris sagittis ut. Integer mattis aliquam purus, interdum ultrices enim elementum in. Suspendisse volutpat ultricies urna, at fermentum arcu viverra et. Integer id consectetur diam, at molestie nulla. </p>";

        return [
            'title' => fake()->words(5, true),
            'subtitle' => fake()->words(5, true),
            'content' => $content,
            'date' => fake()->date('d.m.Y'),
            'time' => fake()->time(),
            'photo' => $photos[rand(0,count($photos)-1)],
            'writer_id' => rand(1, 10),
            'section' => $sections[rand(0, 2)],
            'description' => fake()->words(50, true),
            'readTime' => rand(1, 10)

        ];
    }
}
