export const sendPost = async (data) => {
  try {
    const response = await fetch('./submit.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(data),
    });

    if (response.ok) {
      console.log('Результаты успешно отправлены на сервер.');
    } else {
      console.error('Ошибка при отправке результатов на сервер.');
    }
  } catch (error) {
    console.error('Ошибка при выполнении запроса:', error);
  }
}