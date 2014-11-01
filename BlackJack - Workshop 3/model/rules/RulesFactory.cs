using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace BlackJack.model.rules
{
    class RulesFactory
    {
        public IHitStrategy GetHitRule()
        {
            return new Soft17Strategy();
            //return new BasicHitStrategy();
            
        }

        public INewGameStrategy GetNewGameRule()
        {
            return new AmericanNewGameStrategy();
            //return new InternationalNewGameStrategy();
        }

        public IDecideWinnerStrategy GetWinnerRule()
        {
            return new PlayerWinnerStrategy();
            //return new DealerWinnerStrategy();

        }
    }
}
