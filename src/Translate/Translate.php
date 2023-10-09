<?php

declare(strict_types=1);

namespace Orchid\Translate;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class Translate
{

    public const TABLE = 'translates';

    public const LAYOUT_TYPE = 1;
    public const ADMIN_TYPE = 2;
    public const TYPES = [
        self::LAYOUT_TYPE,
        self::ADMIN_TYPE,
    ];

    protected $key;

    protected $translate;

    protected $language_id;

    protected $type;

    protected $db_connection = '';

    /**
     * The function initializes several variables including the current timestamp, user ID, IP address,
     * and database connection.
     */
    public function __construct()
    {
        $this->db_connection = config('platform.translate.connection', config('database.default'));
        $this->_checkTable();
    }

    public function get(string $key, int $language_id): self
    {
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
            'key' => $this->key,
            'translate' => $this->translate,
            'language_id' => $this->language_id,
            'type' => $this->type,
        ];
    }

    /**
     * The function checks if a table exists in the database and creates it if it doesn't.
     * 
     * @return void
     */
    private function _checkTable(): void
    {
        $schema = Schema::connection($this->db_connection);
        if (!$schema->hasTable(self::TABLE)) {
            $schema->create(self::TABLE, function (Blueprint $table) {
                $table->string('key');
                $table->string('translate')->nullable();
                $table->unsignedBigInteger('language_id');
                $table->integer('type');
            });
        }
    }
}
