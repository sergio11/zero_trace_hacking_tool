import logging

from zero_trace.results.results_formatter import SearchResultsFormatter
from zero_trace.search.dork_generator import DorkGenerator
from zero_trace.search.search_engine import SearchEngine
from zero_trace.utils.file_downloader import FileDownloader

logging.basicConfig(level=logging.INFO, format='%(asctime)s - %(levelname)s - %(message)s')

class SearchArgs:
    """
    Encapsulates common search arguments for ZeroTrace.
    
    Attributes:
        start_page (int): The starting page for search results.
        pages (int): The number of result pages to fetch.
        lang (str): The language for the search results.
    """
    def __init__(self, start_page=1, pages=1, lang="lang_es"):
        self.start_page = start_page
        self.pages = pages
        self.lang = lang


class ZeroTrace:
    """
    ZeroTrace class: Handles Google search execution and result processing using AI for Dork generation.
    """

    def __init__(self, google_api_key, search_engine_id, groq_api_key, output_html=None, output_json=None, download=None, download_file_extensions=None, download_folder=None):
        """
        Initialize the ZeroTrace class with API keys and optional export/download settings.
        
        Args:
            google_api_key (str): Google API key.
            search_engine_id (str): Google Custom Search engine ID.
            groq_api_key (str): Groq API key for AI dork generation.
            output_html (str): Path to export results as HTML (optional).
            output_json (str): Path to export results as JSON (optional).
            download (str): File types to download (comma-separated, optional).
            download_file_extensions (str): Specific file extensions to download, separated by commas (optional).
            download_folder (str): Path to the folder where downloaded files will be saved (optional).
        """
        self.google_api_key = google_api_key
        self.search_engine_id = search_engine_id
        self.groq_api_key = groq_api_key
        self.output_html = output_html
        self.output_json = output_json
        self.download = download
        self.download_file_extensions = download_file_extensions
        self.download_folder = download_folder

        self.gsearch = SearchEngine(google_api_key, search_engine_id)
        self.dork_generator = None

        logging.info("🔍 ZeroTrace initialized with Google API key and search engine ID.")
        logging.info(f"📁 Download folder set to: {self.download_folder}")
        logging.info(f"📥 File extensions to download: {self.download_file_extensions if self.download_file_extensions else 'all'}")

    def search_with_dork(self, query, search_args: SearchArgs):
        """
        Executes a search using a custom dork or query.
        
        Args:
            query (str): The search query or dork.
            search_args (SearchArgs): Object encapsulating search-related parameters.
        
        Returns:
            Processed search results.
        """
        if not query:
            raise ValueError("A search query is required.")
        
        logging.info(f"🚀 Running search with query: {query}")
        logging.debug(f"📄 Search parameters: start_page={search_args.start_page}, pages={search_args.pages}, lang={search_args.lang}")
        
        results = self.gsearch.search(query, start_page=search_args.start_page, pages=search_args.pages, lang=search_args.lang)
        
        logging.info(f"✅ Search completed. Processing {len(results)} results.")
        return self._process_results(results)

    def generate_dork_and_search(self, description, search_args: SearchArgs):
        """
        Generates a dork using AI based on a description and runs the search.
        
        Args:
            description (str): Description to generate the dork.
            search_args (SearchArgs): Object encapsulating search-related parameters.
        
        Returns:
            Processed search results.
        """
        if not description:
            raise ValueError("A dork description must be provided.")
        
        logging.info(f"📝 Generating Google Dork for description: {description}")

        if not self.dork_generator:
            logging.info("⚙️ Initializing DorkGenerator with Groq API key.")
            self.dork_generator = DorkGenerator(groq_api_key=self.groq_api_key)

        dork = self.dork_generator.generate_dork(description)
        logging.info(f"✅ Generated Dork: {dork}")

        return self.search_with_dork(dork, search_args)

    def _process_results(self, results):
        """
        Processes and exports search results.
        
        Args:
            results (list of dict): The search results.
        
        Returns:
            None
        """
        rparser = SearchResultsFormatter(results)

        # Display results in the console
        logging.info("🖥️ Displaying results in the console.")
        rparser.display_console()

        # Export results to HTML if specified
        if self.output_html:
            logging.info(f"📄 Exporting results to HTML: {self.output_html}")
            rparser.export_html(self.output_html)

        # Export results to JSON if specified
        if self.output_json:
            logging.info(f"📊 Exporting results to JSON: {self.output_json}")
            rparser.export_json(self.output_json)

        # Download specified files from the results
        if self.download_file_extensions:
            logging.info(f"📥 Downloading files with types: {self.download_file_extensions}")
            file_types = self.download_file_extensions.split(",")
            urls = [result['link'] for result in results]
            fdownloader = FileDownloader(self.download_folder)
            fdownloader.filter_and_download_files(urls, file_types)
            
        logging.info("✅ Results processed successfully.")
