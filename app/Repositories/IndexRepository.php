<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class IndexRepository
 */
class IndexRepository
{
    public Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function parseQueryParams(array $params)
    {
        return [
            'first' => $params['first'] ?? false,
            'rows' => $params['rows'] ?? false,
            'orderBy' => $params['orderBy'] ?? 'updated_at',
            'ascending' => $params['ascending'] ?? 0,
            'filters' => $filters = is_array($params['filters'] ?? null) ? $params['filters'] : json_decode($params['filters'] ?? '{}', true),
            'columns' => isset($params['columns']) ? json_decode($params['columns']) : array_keys($filters),
        ];
    }

    public function getModelQuery($first, $rows, $orderBy, $ascending, $filters, $columns = null)
    {
        $query = $this->model::query()->selectRaw($this->model->getTable() . '.*');

        if (method_exists($this->model, 'scopeWithAliasScopes')) {
            $query->withAliasScopes($columns);
        }

        $filters = array_filter($filters, function ($filter) {
            return isset($filter['value'])
                && $filter['value'] !== null
                && $filter['value'] !== ''
                && $filter['value'] !== '%%';
        });
        foreach ($filters as $column => $filter) {
            $query->filterByColumn($column, $filter['value'], $filter['matchMode'] ?? null);
        }

        $order = $ascending === '1' ? 'ASC' : 'DESC';
        $query->orderByColumn($orderBy, $order);

        return $query;
    }

    public function paginateQuery($query, $first, $rows, $columns)
    {
        $count = DB::query()->from($query)->count();

        if ($rows !== false && $first !== false) {
            $query->offset($first)->limit($rows);
        }

        $data = $query->get();

        $data = $data->map(function ($_data) use ($columns) {
            return $_data->only($columns);
        });

        return [
            'data' => $data,
            'count' => $count,
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @author Jorge Solis <jorge.solis@cceo.com.mx>
     */
    public function index($first, $rows, $orderBy, $ascending, $filters, $columns)
    {
        array_push($columns, 'id');

        $query = $this->getModelQuery($first, $rows, $orderBy, $ascending, $filters, $columns);

        return $this->paginateQuery($query, $first, $rows, $columns);
    }
}