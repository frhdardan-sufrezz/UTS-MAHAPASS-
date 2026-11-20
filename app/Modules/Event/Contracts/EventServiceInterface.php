<?php

namespace App\Modules\Event\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Pintu masuk resmi ke modul Event bagi modul lain.
 * Semua method mengembalikan array/scalar (bukan model Eloquent).
 */
interface EventServiceInterface
{
    public function paginate(array $filters = [], int $perPage = 9, bool $onlyPublished = true): LengthAwarePaginator;

    public function find(int $id): ?array;

    public function exists(int $id): bool;

    /** @return int[] */
    public function allIds(): array;

    /** @return array<int,string> id => nama */
    public function kategoriOptions(): array;

    /** @return array<int,string> id => nama */
    public function kampusOptions(): array;

    /** @return array<int,string> id => nama */
    public function organizerOptions(): array;

    public function create(array $data): array;

    public function update(int $id, array $data): array;

    public function delete(int $id): void;
}
