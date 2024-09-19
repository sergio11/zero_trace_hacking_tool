import requests
from requests.exceptions import RequestException


class GoogleSearchError(Exception):
    """Custom exception to handle Google Search API errors."""
    pass


class GoogleSearch:
    """
    A class to interact with the Google Custom Search API.

    Attributes:
        api_key (str): Google API key.
        engine_id (str): Google Custom Search Engine (CSE) ID.
    """

    def __init__(self, api_key, engine_id):
        """
        Initializes the GoogleSearch instance with the required API key and CSE ID.

        Args:
            api_key (str): Google API key.
            engine_id (str): Google Custom Search Engine ID.
        """
        self.api_key = api_key
        self.engine_id = engine_id

    def _custom_results(self, results):
        """
        Formats the raw search results from the Google API into a simplified structure.

        Args:
            results (list): List of raw result items from the Google API response.

        Returns:
            list: A list of dictionaries with 'title', 'description', and 'link' keys.
        """
        custom_results = []
        for result in results:
            cresult = {
                "title": result.get("title"),
                "description": result.get("snippet"),
                "link": result.get("link")
            }
            custom_results.append(cresult)
        return custom_results

    def search(self, query, start_page=1, pages=1, lang="lang_es"):
        """
        Performs a search query using Google Custom Search API.

        Args:
            query (str): The search query string.
            start_page (int, optional): The starting page number (default is 1).
            pages (int, optional): Number of result pages to retrieve (default is 1).
            lang (str, optional): Language code for filtering results (default is 'lang_es' for Spanish).

        Returns:
            list: A list of dictionaries containing title, description, and link of search results.

        Raises:
            GoogleSearchError: If an error occurs while making the API request.
        """
        if pages < 1 or start_page < 1:
            raise ValueError("Pages and start_page must be greater than or equal to 1.")

        final_results = []
        results_per_page = 10

        for page in range(pages):
            start_index = (start_page - 1) * results_per_page + 1 + (page * results_per_page)
            url = f"https://www.googleapis.com/customsearch/v1?key={self.api_key}&cx={self.engine_id}&q={query}&start={start_index}&lr={lang}"

            try:
                response = requests.get(url, headers={"Accept": "application/json"})
                response.raise_for_status()  # Raise an exception for bad status codes
            except RequestException as e:
                error_msg = f"Failed to retrieve results for page {page + 1}. Error: {e}"
                print(error_msg)
                raise GoogleSearchError(error_msg) from e

            # Parse the response and process the results
            data = response.json()
            results = data.get("items", [])
            if not results:
                print(f"No results found on page {page + 1}.")
                break

            # Append custom formatted results
            final_results.extend(self._custom_results(results))

        return final_results