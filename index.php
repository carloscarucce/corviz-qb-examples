<?php

$options = [
    'host' => 'localhost',
    'user' => 'root',
    'pass' => '',
    'database' => 'test',
];

#region Debug classes/functions
require __DIR__.'/vendor/autoload.php';

class DebugConnection extends \Corviz\Connector\PDO\Connection
{
    /**
     * @param array ...$args
     *
     * @return \Corviz\Database\Result
     */
    public function nativeQuery(...$args): \Corviz\Database\Result
    {
        echo '<div style="background: #ddd; padding: 15px 7px;">', nl2br($args[0]), '</div><br/>';
        return parent::nativeQuery(...$args);
    }
}

function print_result(\Corviz\Database\Result $result) {
    echo "Result:<pre>",json_encode($result->fetchAll(), JSON_PRETTY_PRINT),"</pre><hr/>";
}

$connection = new DebugConnection([
    'dsn' => "mysql:host={$options['host']};dbname={$options['database']};charset=utf8",
    'user' => $options['user'],
    'password' => $options['pass']
]);
#endregion

#region test1: simple select
$query = $connection->createQuery();

$result = $query->from('user')
            ->execute();

print_result($result);
#endregion

#region test2: where
$query = $connection->createQuery();

$result = $query->from('user')
    ->where(function($where){
        $where->and('name', 'like', '?');
    })
    ->execute(['%Do%']);

print_result($result);
#endregion

#region inner join
$query = $connection->createQuery();

$result = $query->from('user')
    ->join('post', function($join){
        $join->inner();
        $join->on(function($clause){
            $clause->and('post.user_id', '=', 'user.id');
        });
    })
    ->select('post.id', 'post.title', 'user.name')
    ->execute();

print_result($result);
#endregion

#region left join
$query = $connection->createQuery();

$result = $query->from('user')
    ->join('post', function($join){
        $join->left();
        $join->on(function($clause){
            $clause->and('post.user_id', '=', 'user.id');
            $clause->in('user.id', ['?', '?']);
        });
    })
    ->select('post.id', 'post.title', 'user.name')
    ->execute([1,3]);

print_result($result);
#endregion

#region order by
$query = $connection->createQuery();

$result = $query->from('post')
    ->select('post.id', 'post.title')
    ->orderBy('title', 'desc')
    ->execute();

print_result($result);
#endregion

#region limit
$query = $connection->createQuery();

$result = $query->from('post')
    ->limit(1)
    ->execute();

print_result($result);
#endregion

#region limit/offset
$query = $connection->createQuery();

$result = $query->from('post')
    ->limit(2)
    ->offset(2)
    ->execute();

print_result($result);
#endregion

#region union
$query = $connection->createQuery();
$query2 = $connection->createQuery();

$query->from('post')->where(function($where){
    $where->and('id', '=', '1');
});

$query2->from('post')->where(function($where){
    $where->and('id', '=', '3');
});

$query->union($query2);

$result = $query->execute();

print_result($result);
#endregion