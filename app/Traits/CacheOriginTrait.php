<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait CacheOriginTrait
{
    public string $keyCache = 'origins';

    public function clearCache(): void
    {
        Cache::store('file')->forget($this->keyCache);
    }

    
    /**
     * Method updateCache
     *
     * @param array<string> $origins
     *
     * @return void
     */
    public function updateCache(array $origins): void
    {
        Cache::store('file')->forget($this->keyCache);
        cache::store('file')->add($this->keyCache, $origins);
    }
    
    /**
     * Method getOrigins
     *
     * @return array<string>
     */
    public function getOrigins(): array
    {
        return (array)cache::store('file')->get($this->keyCache);
    }
}
