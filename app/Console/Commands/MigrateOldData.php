<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\Form;
use App\Models\Order;
use App\Models\Price;
use App\Models\Response;
use App\Models\Ticket;
use App\Models\TicketType;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class MigrateOldData extends Command
{
    protected $signature = 'data:migrate';

    protected $description = 'Migrate Data';

    public $files;
    public $dataFolder;
    public $lookup;

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->files = app('files');
        $this->dataFolder = Str::finish(env('MIGRATOR_DATA'), '/');

        $this->handleEvents();
        $this->handleUsers();
        $this->handlePermissions();
        $this->handleFormsAndResponses();
        $this->handleOrders();
        // $this->handleDonations();
    }

    public function handleEvents()
    {
        $eventsData = $this->getData('events');

        foreach($eventsData as $eventData) {
            $event = Event::factory()->preset('mblgtacc')->create(['name' => $eventData->title, 'location' => $eventData->location, 'timezone' => $eventData->timezone, 'start' => $eventData->start, 'end' => $eventData->end, 'description' => $eventData->description, 'created_at' => $eventData->created_at, 'updated_at' => $eventData->updated_at]);

            $this->addToLookup('events', $eventData->id, $event);
        }

        $this->echoMessage('events', count($eventsData));

        $ticketTypesData = $this->getData('ticket_types');

        foreach($ticketTypesData as $ticketTypeData) {
            $ticketType = TicketType::create(['event_id' => $this->lookup['events'][$ticketTypeData->event_id]->id, 'name' => $ticketTypeData->name, 'structure' => 'flat', 'description' => $ticketTypeData->description, 'start' => $ticketTypeData->availability_start, 'end' => $ticketTypeData->availability_end, 'timezone' => $this->lookup['events'][$ticketTypeData->event_id]->timezone, 'created_at' => $ticketTypeData->created_at, 'updated_at' => $ticketTypeData->updated_at]);
            Price::create(['ticket_type_id' => $ticketType->id, 'name' => $ticketType->name, 'cost' => $ticketTypeData->cost, 'start' => $ticketTypeData->availability_start, 'end' => $ticketTypeData->availability_end, 'timezone' => $this->lookup['events'][$ticketTypeData->event_id]->timezone, 'created_at' => $ticketTypeData->created_at, 'updated_at' => $ticketTypeData->updated_at]);

            $this->addToLookup('ticket_types', $ticketTypeData->id, $ticketType);
        }

        $this->echoMessage('ticket_types', count($ticketTypesData));
    }

    public function handleUsers()
    {
        $usersData = $this->getData('users');
        $profileData = $this->getData('profiles');

        foreach($usersData as $userData) {
            $user = User::create(['name' => $userData->name, 'email' => $userData->email, 'pronouns' => $profileData->firstWhere('user_id', $userData->id)->pronouns ?? null, 'password' => $userData->password, 'email_verified_at' => $userData->email_verified_at, 'created_at' => $userData->created_at, 'updated_at' => $userData->updated_at, 'programs_stripe_id' => $userData->mblgtacc_stripe_id, 'donations_stripe_id' => $userData->institute_stripe_id ]);

            $this->addToLookup('users', $userData->id, $user);
        }

        $this->echoMessage('users', count($usersData));
    }

    public function handlePermissions()
    {
        $rolesData = $this->getData('roles');
        $permissionsData = $this->getData('permissions');
        $roleHasPermissionsData = $this->getData('role_has_permissions');
        $modelHasPermissionsData = $this->getData('model_has_permissions', true);
        $modelHasRolesData = $this->getData('model_has_roles', true);

        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        foreach($rolesData as $roleData) {
            $role = Role::findOrCreate($roleData->name);
            $this->addToLookup('roles', $roleData->id, $role);
        }
        $this->echoMessage('roles', count($rolesData));

        foreach($permissionsData as $permissionData) {
            $permission = Permission::findOrCreate($permissionData->name);
            $this->addToLookup('permissions', $permissionData->id, $permission);
        }
        $this->echoMessage('permissions', count($permissionsData));

        foreach($roleHasPermissionsData as $roleHasPermissionData) {
            $this->lookup['roles'][$roleHasPermissionData->role_id]->givePermissionTo($this->lookup['permissions'][$roleHasPermissionData->permission_id]->name);
        }
        echo "Inserted role_has_permissions data\n";

        foreach($modelHasPermissionsData as $data) {
            DB::table('model_has_permissions')->insert($data);
        }
        echo "Inserted model_has_permissions data\n";
        foreach($modelHasRolesData as $data) {
            DB::table('model_has_roles')->insert($data);
        }
        echo "Inserted model_has_roles data\n";
    }

    public function handleFormsAndResponses()
    {
        $formsData = $this->getData('forms');
        $responsesData = $this->getData('responses');

        foreach($formsData as $formData) {
            $form = Form::create(['name' => $formData->name, 'type' => $formData->type ?? 'workshop', 'auth_required' => $formData->auth_required, 'list_id' => $formData->list_id, 'event_id' => $this->lookup['events'][$formData->event_id]->id ?? $formData->event_id, 'start' => $formData->start, 'end' => $formData->end, 'timezone' => 'America/Chicago', 'form' => $formData->form, 'created_at' => $formData->created_at, 'updated_at' => $formData->updated_at]);

            $this->addToLookup('forms', $formData->id, $form);
        }

        $this->echoMessage('forms', count($formsData));

        foreach($responsesData as $responseData) {
            $response = Response::create(['form_id' => $this->lookup['forms'][$responseData->form_id]->id, 'user_id' => $this->lookup['users'][$responseData->user_id]->id ?? null, 'type' => $this->lookup['forms'][$responseData->form_id]->type, 'email' => $responseData->email, 'answers' => $responseData->responses, 'created_at' => $responseData->created_at, 'updated_at' => $responseData->updated_at]);

            $this->addToLookup('responses', $responseData->id, $response);
        }

        $this->echoMessage('responses', count($responsesData));
    }

    public function handleOrders()
    {
        $ordersData = $this->getData('orders')->where('deleted_at', null);
        $receiptsData = $this->getData('receipts');
        $invoicesData = $this->getData('invoices');

        foreach($ordersData as $orderData) {
            $receiptData = $receiptsData->firstWhere('order_id', $orderData->id);
            $invoiceData = (array) $invoicesData->firstWhere('order_id', $orderData->id);

            if($invoiceData) {
                $formattedInvocie = [
                    'created_at' => Carbon::parse($invoiceData['created_at'])->format('m/d/Y'),
                    'due_date' => Carbon::parse($invoiceData['created_at'])->addDays(60)->format('m/d/Y'),
                    'billable' => implode("\n", Arr::only($invoiceData, ['name', 'email', 'address', 'address_2', 'city', 'state', 'zip'])),
                ];
            }

            if($receiptData) {
                $order = Order::create(['event_id' => $this->lookup['events'][$orderData->event_id]->id, 'user_id' => $this->lookup['users'][$orderData->user_id]->id, 'confirmation_number' => $orderData->confirmation_number, 'transaction_id' => $receiptData->transaction_id ?? null, 'amount' => $receiptData->amount, 'paid_at' => $receiptData->created_at, 'invoice' => $formattedInvocie ?? null, 'created_at' => $orderData->created_at, 'updated_at' => $orderData->updated_at,]);

                $this->addToLookup('orders', $orderData->id, $order);
            }

        }

        $this->echoMessage('orders', count($ordersData));

        $ticketsData = $this->getData('tickets')->whereIn('order_id', array_keys($this->lookup['orders']));

        foreach($ticketsData as $ticketData) {
            Ticket::create(['order_id' => $this->lookup['orders'][$ticketData->order_id]->id, 'ticket_type_id' => $this->lookup['ticket_types'][$ticketData->ticket_type_id]->id, 'user_id' => $this->lookup['users'][$ticketData->user_id]->id ?? null, 'created_at' => $ticketData->created_at, 'updated_at' => $ticketData->updated_at, 'deleted_at' => $ticketData->deleted_at]);
        }

        echo "Imported tickets";
    }

    private function addToLookup($table, $oldId, $new)
    {
        $this->lookup[$table][$oldId] = $new;
    }

    public function echoMessage($table, $oldCount)
    {
        echo 'Imported ' . count($this->lookup[$table]). ' of ' . $oldCount . ' ' . $table . "\n";
    }

    private function getData($table, $array = false)
    {
        if($array) {
            return collect(json_decode($this->files->get($this->dataFolder.$table.'.json'), true));
        }
        return collect(json_decode($this->files->get($this->dataFolder.$table.'.json')));
    }
}
