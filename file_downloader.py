import os
import requests

class FileDownloader:
    """A class for downloading files from specified URLs and saving them locally.

    Attributes:
        target_directory (str): The destination directory where downloaded files will be stored.
    """

    def __init__(self, target_directory):
        """Initializes the FileDownloader with a target directory.

        Args:
            target_directory (str): The path of the directory where downloaded files will be stored.
        """
        self.target_directory = target_directory
        self._create_directory()

    def _create_directory(self):
        """Creates the target directory if it does not exist."""
        if not os.path.exists(self.target_directory):
            os.makedirs(self.target_directory)

    def download_file(self, url):
        """Downloads a single file from a specified URL and saves it to the target directory.

        Args:
            url (str): The URL of the file to download.

        Raises:
            Exception: Captures any exceptions during the HTTP request or file writing,
                        and reports the error.
        """
        try:
            response = requests.get(url)
            response.raise_for_status()  # Raise an error for bad responses
            file_name = url.split('/')[-1]
            full_path = os.path.join(self.target_directory, file_name)

            with open(full_path, 'wb') as file:
                file.write(response.content)

            print(f"File '{file_name}' downloaded to '{full_path}'.")
        except requests.exceptions.RequestException as e:
            print(f"Error downloading file '{url}': {e}")

    def filter_and_download_files(self, urls, file_types=["all"]):
        """Filters and downloads files from a list of URLs based on specified file extensions.

        Args:
            urls (list): A list of URLs of files to download.
            file_types (list): A list of file extensions to download,
                               or "all" to download all files.

        Notes:
            - If file_types is set to ["all"], all files will be downloaded.
            - Only URLs ending with the specified extensions will be downloaded if other types are provided.
        """
        if file_types == ["all"]:
            for url in urls:
                self.download_file(url)
        else:
            for url in urls:
                if any(url.endswith(f".{file_type}") for file_type in file_types):
                    self.download_file(url)