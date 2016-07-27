<?php
/**
 * Перенос кода оригинальной библиотеки из JS в PHP.
 *
 * @link https://github.com/maximal/reduplicator
 * @author MaximAL
 * @since 2016-07-27
 * @time 16:32
 * @package reduplicate
 * @copyright © MaximAL, Sijeko 2016
 */

namespace maximal\reduplicate;


class Reduplicator
{
	/**
	 * Шм-редупликация текста.
	 * @param string $text Исходный текст
	 * @return string Возвращает результат шм-редупликации
	 * @throws \Exception Ещё не реализовано
	 */
	public static function shmReduplicate($text) {
		throw new \Exception('Not implemented yet.');
	}


	/**
	 * Хуй-редупликация текста.
	 * @param string $text Исходный текст
	 * @return string Возвращает результат хуй-редупликации
	 */
	public static function huiReduplicate($text) {
		// Все русские буквы
		$allRu = 'а-яё';

		// Все русские буквы
		return preg_replace_callback(
			'/[' . $allRu . ']+/ui',
			function ($word) {
				// Все русские буквы
				$vowelsRu = 'аеёиоуэюя';

				// Все слоги
				return preg_replace_callback(
					'/([^' . $vowelsRu . ']*)([' . $vowelsRu . '])/ui',
					function ($matches) {
						$rep = null;
						switch ($matches[2]) {
							case 'а':
							case 'А':
								// шапка → хуяпка
								$rep = 'я';
								break;
							case 'о':
							case 'О':
								// опера → хуёпера
								$rep = 'ё';
								break;
							case 'у':
							case 'У':
								// ушко → хуюшко
								$rep = 'ю';
								break;
							case 'э':
							case 'Э':
								// эльф → хуельф
								$rep = 'е';
								break;
							default:
								$rep = $matches[2];
								break;
						}

						// Если первая буква — строчная, возвращаем строчную
						$firstLetter = mb_substr($matches[1], 0, 1);
						if (mb_strtolower($firstLetter) === $firstLetter) {
							return 'ху' . mb_strtolower($rep);
						}

						// Если первая буква — прописная, возвращаем прописную
						return 'Ху' . mb_strtolower($rep);
					},
					$word[0],
					1 // Нужно обработать только первый слог в слове, не больше
				);
			},
			$text
		);
	}
}
