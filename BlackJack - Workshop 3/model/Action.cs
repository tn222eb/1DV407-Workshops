using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace BlackJack.model
{
    class Action
    {
        public enum Value
        {
            Play = 0,
            Hit,
            Stand,
            Quit,
            NoChosen    
        }
    }
}
