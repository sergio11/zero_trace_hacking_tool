
from googlesearch import GoogleSearch
from results_parser import ResultsProcessor


class ZeroTrace:
    """
    ZeroTrace class: Handles Google search execution and result processing.
    
    Attributes:
        google_api_key (str): The Google API key for the Custom Search API.
        search_engine_id (str): The search engine ID for the Custom Search API.
    """

    def __init__(self, google_api_key, search_engine_id):
        """
        Initialize the ZeroTrace class with the provided API key and search engine ID.
        
        Args:
            google_api_key (str): The Google API key.
            search_engine_id (str): The Google Custom Search engine ID.
        """
        if not google_api_key or not search_engine_id:
            raise ValueError("API key and Search Engine ID must be provided.")
        
        self.google_api_key = google_api_key
        self.search_engine_id = search_engine_id

        # Initialize the GoogleSearch object with the provided credentials
        self.gsearch = GoogleSearch(self.google_api_key, self.search_engine_id)

    def run_search(self, query, start_page=1, pages=1, lang="lang_es"):
        """
        Executes a Google search based on the provided query and returns the results.

        Args:
            query (str): The Google search query or dork.
            start_page (int): The initial page of the search results (default is 1).
            pages (int): The number of result pages to fetch (default is 1).
            lang (str): The language of the search results (default is Spanish: "lang_es").

        Returns:
            list of dict: The search results.
        """
        if not query:
            raise ValueError("A search query is required.")

        try:
            return self.gsearch.search(query, start_page=start_page, pages=pages, lang=lang)
        except Exception as e:
            raise RuntimeError(f"Failed to perform the search: {str(e)}")

    def process_results(self, results, output_html=None, output_json=None):
        """
        Processes and displays the search results. Optionally exports results to HTML or JSON.

        Args:
            results (list of dict): The search results to process.
            output_html (str): Path to export the results to an HTML file (optional).
            output_json (str): Path to export the results to a JSON file (optional).
        """
        rparser = ResultsProcessor(results)

        # Display results in the console
        rparser.display_console()

        # Export results to HTML if specified
        if output_html:
            rparser.export_html(output_html)

        # Export results to JSON if specified
        if output_json:
            rparser.export_json(output_json)