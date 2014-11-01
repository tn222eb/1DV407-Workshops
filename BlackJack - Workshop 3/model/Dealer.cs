using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace BlackJack.model
{
    class Dealer : Player
    {
        private Deck m_deck = null;
        private const int g_maxScore = 21;

        private rules.INewGameStrategy m_newGameRule;
        private rules.IHitStrategy m_hitRule;
        private rules.IDecideWinnerStrategy m_winner;

        public Dealer(rules.RulesFactory a_rulesFactory)
        {
            m_newGameRule = a_rulesFactory.GetNewGameRule();
            m_hitRule = a_rulesFactory.GetHitRule();
            m_winner = a_rulesFactory.GetWinnerRule();
        }

        public bool NewGame(Player a_player)
        {
            if (m_deck == null || IsGameOver())
            {
                m_deck = new Deck();
                ClearHand();
                a_player.ClearHand();
                return m_newGameRule.NewGame(m_deck, this, a_player);   
            }
            return false;
        }

        public bool Hit(Player a_player)
        {
            if (m_deck != null && a_player.CalcScore() < g_maxScore && !IsGameOver())
            {
                DealCard(a_player, true);

                return true;
            }
            return false;
        }

        public void Stand(Player a_dealer)
        {
            if (m_deck != null) 
            {
                ShowHand();
            }

            while (m_hitRule.DoHit(a_dealer)) {
                m_hitRule.DoHit(a_dealer);

                DealCard(a_dealer, true);   
            }

        }

        public bool IsDealerWinner(Player a_player, Dealer a_dealer)
        {
            return m_winner.DecideWinner(a_player, a_dealer);
        }

        public bool IsGameOver()
        {
            if (m_deck != null && /*CalcScore() >= g_hitLimit*/ m_hitRule.DoHit(this) != true)
            {
                return true;
            }
            return false;
        }

        public void DealCard(Player player, bool show)
        {
            Card c = m_deck.GetCard();
            
            c.Show(show);
            player.DealCard(c);
        }
    }
}
