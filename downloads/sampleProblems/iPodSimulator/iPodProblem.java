import java.io.File;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Scanner;


public class iPodProblem {
	
	public static void main(String[] args) {
		try {
			File f = new File("input.txt");
			Scanner s = new Scanner(f);
			iPod i = new iPod();
			while (s.hasNextLine()) {
				if (!i.parseCommand(s.nextLine()))
					i = new iPod();
			}
		} catch (Exception e) {
			e.printStackTrace();
		}
	}
}

class iPod {
	String iPodName = "";
	HashMap<String, ArrayList<String>> playlists = new HashMap<String, ArrayList<String>>(10);
	
	public iPod() {
		
	}
	
	public boolean parseCommand(String line) {
		if (line.startsWith("IPOD")) {
			this.iPodName = line.replace("IPOD", "").trim();
			return true;
		} else if (line.startsWith("TRACK")) {
			String playlist = line.substring(line.indexOf("PLAYLIST")+"PLAYLIST".length()).trim();
			String track = line.substring(line.indexOf("TRACK")+"TRACK".length(), line.indexOf("PLAYLIST")).trim();
			playlists.get(playlist).add(track);
			return true;
		} else if (line.startsWith("PLAYLIST")) {
			playlists.put(line.replace("PLAYLIST", "").trim(), new ArrayList<String>(10));
			return true;
		} else if (line.startsWith("DELETE")) {
			String playlist = line.substring(line.indexOf("PLAYLIST")+"PLAYLIST".length()).trim();
			String track = line.substring(line.indexOf("DELETE")+"delete".length(), line.indexOf("PLAYLIST")).trim();
			playlists.get(playlist).remove(track);
			return true;
		} else if (line.startsWith("PLAY")) {
			String playlist = line.replace("PLAY", "").trim();
			System.out.println("Playing "+playlist+" ("+playlists.get(playlist).size()+" Songs)");
			for (String track : playlists.get(playlist)) {
				System.out.println(track);
			}
			return true;
		} else {
			return false;
		}
	}
}
