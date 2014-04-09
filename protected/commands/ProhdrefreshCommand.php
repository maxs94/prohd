<?php
class ProhdrefreshCommand extends CConsoleCommand
{
    public function run($args)
    {
        $characters = Characters::model()->findAll();
        
        foreach ($characters as $character)
        {
            echo "Found character {$character->characterName}\n";
            $walletInterface = new APITransactions();
            $journalInterface = new APIJournal();
            $ordersInterface = new APIOrders();
            $assetsInterface = new APIAssetList();
            $sheetInterface = new APICharacterSheet();
            
            //Wallet
            if ((!($walletInterface->getCacheExpiration($character->walletID))) && ($character->walletEnabled))
            {
                echo "Updating transactions...\n";
                $walletInterface->storeData($character->walletID);
            }
            
            //Journal
            if ((!($journalInterface->getCacheExpiration($character->walletID))) && ($character->journalEnabled))
            {
                echo "Updating journal...\n";
                $journalInterface->storeData($character->walletID);
            }
            
            //Orders
            if((!($ordersInterface->getCacheExpiration($character->walletID))) && ($character->ordersEnabled))
            {
                echo "Updating orders...\n";
                $ordersInterface->storeData($character->walletID);
            }
            
            /*
            //Assets
            if(!($assetsInterface->getCacheExpiration($character->walletID)))
            {
                echo "Updating assets...\n";
                $assetsInterface->storeData($character->walletID);
            }
             */
            
            //Balance
            if((!($sheetInterface->getCacheExpiration($character->walletID))) && ($character->displayBalance))
            {
                echo "Updating balances...\n";
                $sheet = $sheetInterface->getEveData($character->walletID);
		$sheetBalance = $sheet->result->balance[0][0];
                
                $balance = (float)$sheetBalance;
                $balanceRow = new Balances;
                $balanceRow->characterID = $character->characterID;
                $balanceRow->balanceDateTime = $this->getEveTimeSql();
                $balanceRow->balance = $balance;
                $balanceRow->save();
            }
        }
    }
    
    public function getEveTimeSql()
    {
        $time = strtotime("+4 hour");
        $datetime = date( 'Y-m-d H:i:s', $time );

        return $datetime;
    }
}
