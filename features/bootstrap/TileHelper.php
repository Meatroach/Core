<?php

use OpenTribes\Core\Repository\Tile as TileRepository;

/**
 * Description of TileHelper
 *
 * @author BlackScorp<witalimik@web.de>
 */
class TileHelper {

    private $tileRepository;

    function __construct(TileRepository $tileRepository) {
        $this->tileRepository = $tileRepository;
    }

    /**
     * @param boolean $isAccessible
     */
    public function createDummyTile($name,$isAccessible){
        $id = $this->tileRepository->getUniqueId();
        $tile = $this->tileRepository->create($id, $name, $isAccessible);
        $this->tileRepository->add($tile);
    
    }
}
