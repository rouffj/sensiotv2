<?php

namespace App\Repository;

class InMemoryMovieRepository
{
    public function getMovies()
    {
        return [
            ['id' => 1, 'title' => 'Memento', 'releaseDate' => 2000, 'director' => 'Christopher Nolan', 'duration' => '113', 'image' => '/assets/images/movie-image-samples/memento.jpeg'],
            ['id' => 2, 'title' => 'Insomnia', 'releaseDate' => 2002, 'director' => 'Christopher Nolan', 'duration' => '118', 'image' => '/assets/images/movie-image-samples/insomnia.jpeg'],
            ['id' => 3, 'title' => 'The Dark Knight ', 'releaseDate' => 2008, 'director' => 'Christopher Nolan', 'duration' => '152', 'image' => '/assets/images/movie-image-samples/the-dark-knight.jpeg'],
            ['id' => 4, 'title' => 'Inception', 'releaseDate' => 2010, 'director' => 'Christopher Nolan', 'duration' => '148', 'image' => '/assets/images/movie-image-samples/inception.jpeg'],
            ['id' => 5, 'title' => 'Man Of Steel', 'releaseDate' => 2013, 'director' => 'Christopher Nolan', 'duration' => '143', 'image' => '/assets/images/movie-image-samples/man-of-steel.jpeg'],
            ['id' => 6, 'title' => 'Dunkirk', 'releaseDate' => 2017, 'director' => 'Christopher Nolan', 'duration' => '106', 'image' => '/assets/images/movie-image-samples/dunkirk.jpeg'],
        ];
    }

    public function getMovieById(int $id) 
    {
        foreach ($this->getMovies() as $movie) {
            if ($movie['id'] == $id) {
                return $movie;
            }
        }
    }
}