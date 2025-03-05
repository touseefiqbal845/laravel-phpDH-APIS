<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait SearchableTrait
{
    /**
     * Apply search, filters, sorting, and pagination.
     */
    public function scopeApplySearchFilters($query, Request $request, array $searchableColumns = [])
    {
        if ($request->has('keyword') && !empty($searchableColumns)) {
            $keyword = $request->input('keyword');
            $query->where(function ($q) use ($keyword, $searchableColumns) {
                foreach ($searchableColumns as $column) {
                    $q->orWhere($column, 'LIKE', "%{$keyword}%");
                }
            });
        }

        foreach ($request->all() as $filter => $value) {
            if (in_array($filter, $searchableColumns) && !empty($value)) {
                $query->where($filter, 'LIKE', "%{$value}%");
            }
        }

        if ($request->has('sort_by')) {
            $sortBy = $request->input('sort_by');
            $order = $request->input('order', 'desc');
            $query->orderBy($sortBy, $order);
        }

        $limit = $request->input('limit', 10);
        return $query->paginate($limit);
    }
}
