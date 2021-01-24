<?php

namespace App\Factory;

use App\Entity\Cours;
use App\Repository\CoursRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static Cours|Proxy createOne(array $attributes = [])
 * @method static Cours[]|Proxy[] createMany(int $number, $attributes = [])
 * @method static Cours|Proxy findOrCreate(array $attributes)
 * @method static Cours|Proxy random(array $attributes = [])
 * @method static Cours|Proxy randomOrCreate(array $attributes = [])
 * @method static Cours[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Cours[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static CoursRepository|RepositoryProxy repository()
 * @method Cours|Proxy create($attributes = [])
 */
final class CoursFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://github.com/zenstruck/foundry#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            // 'titre' => 'La conscience',
            // 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut facilisis pulvinar convallis. Fusce lacinia eros est, quis volutpat nisi bibendum sit amet. Aenean ut ante risus. Aliquam at egestas ex. Nunc non felis a lacus scelerisque viverra. Nulla a interdum ipsum. Donec nec ligula auctor, imperdiet nisl ac, semper mauris. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin aliquam id velit ac pellentesque. Integer sagittis suscipit ultricies. Nulla neque augue, ultrices vitae nunc eget, aliquam dignissim urna. Vivamus scelerisque porta mauris convallis sollicitudin. Praesent ullamcorper neque non lacus ullamcorper, eget finibus tortor posuere.',
            // 'level' => 'facile',
            // 'duration' => '6h',
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
            // ->afterInstantiate(function(Cours $cours) {})
        ;
    }

    protected static function getClass(): string
    {
        return Cours::class;
    }
}
