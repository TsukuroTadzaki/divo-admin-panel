<?php

declare(strict_types=1);

namespace Orchid\Activity;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class Activity
{

    public const TABLE = 'activity';

    public const ACTION_CREATE = 'create';
    public const ACTION_UPDATE = 'update';
    public const ACTION_DELETE = 'delete';
    public const ACTIONS = [
        self::ACTION_CREATE,
        self::ACTION_UPDATE,
        self::ACTION_DELETE,
    ];

    protected $user_id;

    protected $ip;

    protected $timestamp;

    protected $class;

    protected $data;

    protected $action;

    protected $db_connection = '';

    protected $is_enabled = false;

    protected $except = [
        '_token',
        '_method',
        '_state',
    ];

    /**
     * The function initializes several variables including the current timestamp, user ID, IP address,
     * and database connection.
     */
    public function __construct()
    {
        $this->timestamp = Carbon::now();
        $this->user_id = auth()->id() ?? null;
        $this->ip = request()->ip();
        $this->db_connection = config('platform.activity.connection', config('database.default'));
        $this->is_enabled = config('platform.activity.enabled', false);
        $this->_checkTable();
    }

    /**
     * The create function sets the action, class, and data properties, logs the action, and returns
     * the instance of the class.
     * 
     * @param string $class The "class" parameter is a string that represents the name of the class.
     * @param array $data The "data" parameter is an optional array that can be used to pass additional
     * data or parameters to the create method.
     * 
     * @return self The method is returning an instance of the class itself (self).
     */
    public function create(string $class, array $data = []): self
    {
        $this->action = self::ACTION_CREATE;
        $this->class = $class;
        $this->data = $data ?: request()->except($this->except);
        $this->_log();
        return $this;
    }

    /**
     * The update function sets the action to update, assigns the class and data, logs the action, and
     * returns the instance of the class.
     * 
     * @param string $class The "class" parameter is a string that represents the name of the class.
     * @param array $data The "data" parameter is an optional array that can be used to pass additional
     * data or parameters to the update method.
     * 
     * @return self The method is returning an instance of the class itself (self).
     */
    public function update(string $class, array $data = []): self
    {
        $this->action = self::ACTION_UPDATE;
        $this->class = $class;
        $this->data = $data ?: request()->except($this->except);
        $this->_log();
        return $this;
    }

    /**
     * The delete function sets the action to delete, assigns the class and data, logs the action, and
     * returns the instance of the class.
     * 
     * @param string $class The "class" parameter is a string that represents the name of the class.
     * @param array $data The "data" parameter is an optional array that can be used to pass additional
     * data or parameters to the delete method.
     * 
     * @return self The method is returning an instance of the class itself (self).
     */
    public function delete(string $class, array $data = []): self
    {
        $this->action = self::ACTION_DELETE;
        $this->class = $class;
        $this->data = $data;
        $this->_log();
        return $this;
    }

    /**
     * The function returns the database connection.
     * 
     * @return array An array is being returned.
     */
    public function getConnection(): string
    {
        return $this->db_connection;
    }

    /**
     * The function sets the database connection and returns the current object.
     * 
     * @param string $db_connection The parameter "db_connection" is a string that represents the name
     * or identifier of the database connection.
     * 
     * @return self The method is returning the current instance of the class (self).
     */
    public function setConnection(string $db_connection): self
    {
        $this->db_connection = $db_connection;
        return $this;
    }

    /**
     * The function toArray() returns an array representation of an object with properties user_id, ip,
     * action, class, data, and timestamp.
     * 
     * @return array An array is being returned.
     */
    public function toArray(): array
    {
        return [
            'user_id' => $this->user_id,
            'ip' => $this->ip,
            'action' => $this->action,
            'class' => $this->class,
            'data' => json_encode($this->data),
            'timestamp' => $this->timestamp,
        ];
    }

    /**
     * The `_log` function inserts data into a database table and returns true if successful, otherwise
     * it returns false.
     * 
     * @return void
     */
    private function _log(): void
    {
        if (!$this->is_enabled) {
            return;
        }
        DB::connection($this->db_connection)
            ->table(self::TABLE)
            ->insert($this->toArray());
    }

    /**
     * The function checks if a table exists in the database and creates it if it doesn't.
     * 
     * @return void
     */
    private function _checkTable(): void
    {
        if (!$this->is_enabled) {
            return;
        }
        $schema = Schema::connection($this->db_connection);
        if (!$schema->hasTable(self::TABLE)) {
            $schema->create(self::TABLE, function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->nullable();
                $table->string('ip')->nullable();
                $table->string('action')->nullable();
                $table->string('class')->nullable();
                $table->json('data')->nullable();
                $table->timestamp('timestamp')->nullable();
            });
        }
    }
}
