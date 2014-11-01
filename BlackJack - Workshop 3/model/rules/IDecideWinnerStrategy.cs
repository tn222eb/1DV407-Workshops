using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace BlackJack.model.rules
{
    interface IDecideWinnerStrategy
    {
        bool DecideWinner(Player a_player, Dealer a_dealer); 
    }
}
