<?php


class User extends Table
{
    const TABLE_PATH = PRIVATE_PATH . '/database/users.csv';

    const FIELDS = [
        'email', 'name', 'last_entrance', 'last_update', 'is_online', 'visit_count', 'ip', 'user_agent',
    ];

    const ID_FIELD = 'email';

    public string $email = '';
    public string $name = '';
    public string $last_entrance = '';
    public string $last_update = '';
    public string $is_online = 'false';
    public int $visit_count = 0;
    public string $ip = '';
    public string $user_agent = '';

    protected function getTablePath(): string
    {
        return self::TABLE_PATH;
    }

    protected function getTableFields(): array
    {
        return self::FIELDS;
    }

    protected function getIdField(): string
    {
        return self::ID_FIELD;
    }

    /**
     * @param array $data
     * @return TableInterface
     */
    public function create(array $data): TableInterface
    {
        if (!isset($data['email'], $data['name'])) {
            throw new BadMethodCallException('The create method is excepting exactly two variables "name" and "email"', 500);
        }

        // Adding system values
        $data = $data + [
            'last_entrance' => getCurrentDate(),
            'last_update'   => getCurrentDate(),
            'is_online'     => 'true',
            'visit_count'   => 1,
            'ip'            => $_SERVER['REMOTE_ADDR'],
            'user_agent'    => $_SERVER['HTTP_USER_AGENT']
        ];

        return parent::create($data);
    }

    /**
     * @param array $data
     * @return TableInterface
     */
    public function update(array $data): TableInterface
    {
        // Adding system values
        $data = $data + [
                'last_update' => getCurrentDate(),
                'ip'          => $_SERVER['REMOTE_ADDR'],
                'user_agent'  => $_SERVER['HTTP_USER_AGENT']
            ];

        return parent::update($data);
    }
}