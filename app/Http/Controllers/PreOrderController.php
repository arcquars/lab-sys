<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePreOrderRequest;
use App\Person;
use App\PreOrder;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PreOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['store']);
    }

    /**
     * GET /preorder/index
     * Vista principal del CRUD.
     */
    public function index()
    {
        return view('preorder.home');
    }

    /**
     * GET /preorder/datatable
     * Endpoint server-side para la DataTable.
     * Ordena por created_at desc (más recientes arriba).
     */
    public function getDatatablesData()
    {
        return Laratables::recordsOf(PreOrder::class, function ($query) {
            return $query->orderBy('created_at', 'desc');
        });
    }

    /**
     * POST /preorder/ajaxCreate
     * Crea (id vacío) o actualiza (id presente) una pre-orden.
     * state NO se modifica aquí — solo via PreOrder::changeState().
     */
    public function ajaxCreateOrUpdatePreOrder(StorePreOrderRequest $request)
    {
        $data   = $request->validated();
        $userId = $request->user()->id;
        $year   = (int) date('Y');
        $yy     = substr((string) $year, -2);
        $id     = $request->input('id');

        if ($id) {
            $preorder = PreOrder::find($id);
            if (! $preorder) {
                return response()->json(['success' => false, 'errors' => 'Pre-orden no encontrada.'], 422);
            }

            $preorder->forceFill([
                'branch_id'           => $data['branch_id'],
                'is_stat'             => $data['is_stat'],
                'patient_full_name'   => $data['patient']['full_name'],
                'patient_age'         => $data['patient']['age'] ?? null,
                'patient_gender'      => $data['patient']['gender'],
                'patient_ci'          => $data['patient']['ci'],
                'patient_birth_date'  => $data['patient']['birth_date'] ?? null,
                'patient_diagnosis'   => $data['patient']['diagnosis'] ?? null,
                'patient_physician'   => $data['patient']['physician'] ?? null,
                'tests_snapshot'      => $data['tests'],
                'updated_by'          => $userId,
            ])->save();

            return response()->json(['success' => true, 'id' => $preorder->id]);
        }

        $preorder = DB::transaction(function () use ($data, $userId, $year, $yy) {
            $seq = $this->nextCounterSeq('pre_order', $year);

            $preorder = PreOrder::create([
                'order_number'        => sprintf('ORD-%s-%04d', $yy, $seq),
                'branch_id'           => $data['branch_id'],
                'is_stat'             => $data['is_stat'],
                'patient_full_name'   => $data['patient']['full_name'],
                'patient_age'         => $data['patient']['age'] ?? null,
                'patient_gender'      => $data['patient']['gender'],
                'patient_ci'          => $data['patient']['ci'],
                'patient_birth_date'  => $data['patient']['birth_date'] ?? null,
                'patient_diagnosis'   => $data['patient']['diagnosis'] ?? null,
                'patient_physician'   => $data['patient']['physician'] ?? null,
                'tests_snapshot'      => $data['tests'],
                'state'               => PreOrder::STATE_NUEVO,
                'created_by'          => $userId,
            ]);

            $preorder->statesLog()->create([
                'previous_state' => null,
                'new_state'      => PreOrder::STATE_NUEVO,
                'user_id'        => $userId,
            ]);

            return $preorder;
        });

        return response()->json(['success' => true, 'id' => $preorder->id]);
    }

    /**
     * POST /preorder/ajaxGet
     * Retorna una pre-orden + estructura anidada para rellenar el form.
     */
    public function ajaxGetPreOrder(Request $request)
    {
        $preorder = PreOrder::find($request->input('id'));
        if (! $preorder) {
            return response()->json(['success' => false, 'errors' => 'Pre-orden no encontrada.'], 422);
        }

        $age = "";
        if(is_numeric($preorder->patient_age)){
            if($preorder->patient_age < 1){
                $age = round($preorder->patient_age, 2);
            } else {
                $age = $preorder->patient_age;
            }

        }
        return response()->json([
            'success'  => true,
            'preorder' => [
                'id'                  => $preorder->id,
                'order_number'        => $preorder->order_number,
                'branch_id'           => $preorder->branch_id,
                'state'           => $preorder->state,
                'is_stat'             => (bool) $preorder->is_stat,
                'patient' => [
                    'full_name'  => $preorder->patient_full_name,
                    'age'        => $age,
                    'gender'     => $preorder->patient_gender,
                    'ci'         => $preorder->patient_ci,
                    'birth_date' => optional($preorder->patient_birth_date)->format('Y-m-d'),
                    'diagnosis'  => $preorder->patient_diagnosis,
                    'physician'  => $preorder->patient_physician,
                ],
                'tests' => $preorder->tests_snapshot,
            ],
        ]);
    }

    /**
     * POST /preorder/ajaxSearchPerson
     * Busca pacientes para el flujo "Crear análisis" desde una pre-orden.
     * Coincidencia: ci exacto OR cada palabra suelta del nombre completo
     * con LIKE sobre nombres, apellidos y apellido_materno.
     */
    public function ajaxSearchPerson(Request $request)
    {
        $ci      = trim((string) $request->post('ci', ''));
        $nombres = trim((string) $request->post('nombres', ''));

        $words = preg_split('/\s+/', $nombres, -1, PREG_SPLIT_NO_EMPTY) ?: [];

        if ($ci === '' && count($words) === 0) {
            return response()->json(['success' => true, 'persons' => []]);
        }

        $persons = Person::query()
            ->where(function ($q) use ($ci, $words) {
                if ($ci !== '') {
                    $q->where('ci', $ci);
                }
                foreach ($words as $word) {
                    $like = '%' . $word . '%';
                    $q->orWhere(function ($q2) use ($like) {
                        $q2->where('nombres', 'like', $like)
                           ->orWhere('apellidos', 'like', $like)
                           ->orWhere('apellido_materno', 'like', $like);
                    });
                }
            })
            ->limit(10)
            ->get();

        return response()->json(['success' => true, 'persons' => $persons]);
    }

    /**
     * POST /preorder/ajaxDelete/{id}
     * Soft delete preserva la fila (deleted_at se setea).
     */
    public function ajaxDestroy($id)
    {
        $preorder = PreOrder::find($id);
        if (! $preorder) {
            return response()->json(['success' => false, 'message' => 'Pre-orden no encontrada.'], 422);
        }

        $preorder->delete(); // SoftDeletes trait — setea deleted_at, no borra fila

        return response()->json(['success' => true, 'message' => 'Pre-orden eliminada.']);
    }

    /**
     * POST /pre-orders (API token auth)
     *
     * Crea una pre-orden a partir del payload validado por StorePreOrderRequest.
     * Devuelve 201 con order_number + issued_at, o 422 si la validación falla.
     */
    public function store(StorePreOrderRequest $request)
    {
        $data   = $request->validated();
        $userId = $request->user()->id;
        $year   = (int) date('Y');
        $yy     = substr((string) $year, -2);

        $preOrder = DB::transaction(function () use ($data, $userId, $year, $yy) {
            $seq = $this->nextCounterSeq('pre_order', $year);

            $preOrder = PreOrder::create([
                'order_number'        => sprintf('ORD-%s-%04d', $yy, $seq),
                'branch_id'           => $data['branch_id'],
                'is_stat'             => $data['is_stat'],

                'patient_full_name'   => $data['patient']['full_name'],
                'patient_age'         => $data['patient']['age'] ?? null,
                'patient_gender'      => $data['patient']['gender'],
                'patient_ci'          => $data['patient']['ci'],
                'patient_birth_date'  => $data['patient']['birth_date'] ?? null,
                'patient_diagnosis'   => $data['patient']['diagnosis'] ?? null,
                'patient_physician'   => $data['patient']['physician'] ?? null,

                'tests_snapshot'      => $data['tests'],
                'state'               => PreOrder::STATE_NUEVO,
                'created_by'          => $userId,
            ]);

            $preOrder->statesLog()->create([
                'previous_state' => null,
                'new_state'      => PreOrder::STATE_NUEVO,
                'user_id'        => $userId,
            ]);

            return $preOrder;
        });

        return response()->json([
            'order_number' => $preOrder->order_number,
            'issued_at'    => $preOrder->created_at->format('c'),
        ], 201);
    }

    /**
     * Incrementa atómicamente el counter (name, year) y devuelve el valor nuevo.
     *
     * MySQL: usa INSERT ... ON DUPLICATE KEY UPDATE dentro de la transacción
     * (atomicidad garantizada con rollback si la transacción global falla).
     */
    private function nextCounterSeq($name, $year)
    {
        DB::statement(
            "INSERT INTO counters (name, year, value, created_at, updated_at)
             VALUES (?, ?, 1, NOW(), NOW())
             ON DUPLICATE KEY UPDATE value = value + 1",
            [$name, $year]
        );

        $row = DB::table('counters')
            ->where('name', $name)
            ->where('year', $year)
            ->first();

        return (int) $row->value;
    }
}
