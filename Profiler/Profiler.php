<?php

namespace RAPIBundle\Profiler;

use DateTime;
use RAPIBundle\Response\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Bundle\MongoDBBundle\DataCollector\PrettyDataCollector;
use Symfony\Component\HttpKernel\DataCollector\MemoryDataCollector;
use Symfony\Component\HttpKernel\DataCollector\TimeDataCollector;
use Doctrine\Bundle\DoctrineBundle\DataCollector\DoctrineDataCollector;

/**
 * Class Profiler
 * @package RAPIBundle\Profiler
 */
class Profiler
{
    /**
     * @param ContainerInterface $containerInterface
     * @param SymfonyResponse $response
     */
    public static function get(ContainerInterface $containerInterface, SymfonyResponse $response)
    {
        if ($response instanceof Response) {
            $profile = $containerInterface
                ->get('profiler')
                ->loadProfileFromResponse($response);

            $profiles["token"] = $profile->getToken();

            foreach ($profile->getCollectors() as $collectorKey => $collector) {
                if ($collectorKey === "mongodb") {
                    /* @var PrettyDataCollector $collector */
                    $profiles["mongodb"] = [
                        "queryCount" => $collector->getQueryCount(),
                        "queries" => $collector->getQueries(),
                    ];
                } elseif ($collectorKey === "time") {
                    /* @var TimeDataCollector $collector */
                    $profiles["time"] = [
                        "initTimeSeconds" => $collector->getInitTime() / 1000,
                        "durationSeconds" => $collector->getDuration() / 1000,
                        "startTime" => (new DateTime())->setTimestamp((int)($collector->getStartTime() / 1000)),
                    ];
                } elseif ($collectorKey === "memory") {
                    /* @var MemoryDataCollector $collector */
                    $profiles["memory"] = [
                        "memory" => $collector->getMemory() / (1024 * 1024),
                        "memoryLimit" => $collector->getMemoryLimit() / (1024 * 1024),
                    ];
                } elseif ($collectorKey === "db") {
                    /* @var DoctrineDataCollector $collector */

                    $queries = [];
                    foreach ($collector->getQueries() as $entityName => $entityManager) {
                        foreach ($entityManager as $queryKey => $query) {
                            $queries[$entityName][$queryKey] = $query;
                            $queries[$entityName][$queryKey]["totalTimeMilliSeconds"] = $query['executionMS'];
                            $queries[$entityName][$queryKey]["totalTimedSeconds"] = $query['executionMS'] / 1000;
                            unset($queries[$entityName][$queryKey]["executionMS"]);
                        }
                    }

                    $profiles["db"] = [
                        "totalTimeMilliSeconds" => $collector->getTime(),
                        "totalTimeSeconds" => $collector->getTime() / 1000,
                        "queryCount" => $collector->getQueryCount(),
                        "queries" => $queries,
                    ];
                }
            }

            $response->setProfiler($profiles);
            $response->setContent(json_encode($response->createStructure()));
        }
    }
}
