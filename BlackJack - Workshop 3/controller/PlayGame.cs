using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using BlackJack.model;

namespace BlackJack.controller
{
    class PlayGame : CardListener
    {
        private view.IView a_view;
        private model.Game a_game;

        public PlayGame(model.Game a_game, view.IView a_view) {
            this.a_view = a_view;
            this.a_game = a_game;            
        }

        public bool Play()
        {
            CardDeal();

            if (a_game.IsGameOver())
            {
                a_view.DisplayGameOver(a_game.IsDealerWinner());
            }

            model.Action.Value action = a_view.GetAction();

            if (action == model.Action.Value.Play)
            {
                System.Threading.Thread.Sleep(1500);
                a_game.NewGame();
            }
            else if (action == model.Action.Value.Hit)
            {
                System.Threading.Thread.Sleep(1500);
                a_game.Hit();
            }
            else if (action == model.Action.Value.Stand)
            {
                System.Threading.Thread.Sleep(1500);
                a_game.Stand();
            }

            return action != model.Action.Value.Quit;
        }

        public void CardDeal()
        {
            a_view.DisplayWelcomeMessage();
            a_view.DisplayDealerHand(a_game.GetDealerHand(), a_game.GetDealerScore());
            a_view.DisplayPlayerHand(a_game.GetPlayerHand(), a_game.GetPlayerScore());
        }
    }
}
