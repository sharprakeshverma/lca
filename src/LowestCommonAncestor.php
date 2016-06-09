<?php

namespace Relaxed\LCA;

use Fhaculty\Graph\Vertex;
use Fhaculty\Graph\Graph;
use Graphp\Algorithms\Search\BreadthFirst;

class LowestCommonAncestor
{
    public function __construct(Graph $graph)
    {
        $this->graph = $graph;
    }

    /**
    * @param Vertex $local
    * @param Vertex $remote
    * @return bool
    */
    public function find(Vertex $local, Vertex $remote)
    {
        // Traverse in reverse order the graph when searching;
        $direction = BreadthFirst::DIRECTION_REVERSE;
        // Use BFS algorithm to get all vertices starting with $local to the root.
        $bfs_local = new BreadthFirst($local);
        $vertices_local = $bfs_local->setDirection($direction)->getVertices();
        // Use BFS algorithm to get all vertices starting with $remote to the root.
        $bfs_remote = new BreadthFirst($remote);
        $vertices_remote = $bfs_remote->setDirection($direction)->getVertices();
        // Intersect the $vertices_local and $vertices_remote to get all common
        // ancestors for $local and $remote. If the $vertices_intersection array is
        // not empty then first value should be our solution - the LCA.
        $vertices_intersection = $vertices_local
            ->getVerticesIntersection($vertices_remote)
            ->getMap();
        return reset($vertices_intersection) ?: FALSE;
    }

}

