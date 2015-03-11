in "browse_songs" template ,  at the last and before ?> , add the following code


print "<td align=center width=20><a href=\"http://twitter.com/home?status=Currently listening to ".urlencode($scripturl."/".str_replace(array('{cat}','{id}'),array(1,$data['id']),$links['song_listen']))."\" target=_blank title='Share it on Twitter'><img src='images/twitter.jpg' alt='Share it on Twitter' border=0></a></td>";