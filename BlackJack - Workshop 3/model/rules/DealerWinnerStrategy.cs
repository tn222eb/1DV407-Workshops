using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace BlackJack.model.rules
{
    class DealerWinnerStrategy : IDecideWinnerStrategy
    {
        private const int g_maxScore = 21;

        public bool DecideWinner(Player a_player, Dealer a_dealer)
        {
            if (a_player.CalcScore() > g_maxScore)
            {
                return true;
            }
            else if (a_dealer.CalcScore() > g_maxScore)
            {
                return false;
            }
            else if (a_dealer.CalcScore() >= a_player.CalcScore())
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }
}
