import java.io.File;
import java.util.Scanner;

public class Jimmy {

	public static void main(String[] args) {
		File input = new File("\\D:JimmyInput.txt");
		try {
			Scanner in = new Scanner(input);
			while (in.hasNextLine()) {
				int numRotations = Integer.parseInt(in.nextLine());
				String direction = in.nextLine();
				
				// set up stash
				String[] stashTemp = in.nextLine().split(" ");
				int[] stash = new int[stashTemp.length];
				for(int i = 0; i < stash.length; i++){
					stash[i] = Integer.parseInt(stashTemp[i]);
				}
				
				// print solution
				int[] fixedStash = rotate(stash, numRotations, direction);
				for (int length : fixedStash)
					System.out.print(length + " ");

				System.out.println();
			}
		} catch (Exception e) {
			System.out.println("ouch");
		}

	}

	public static int[] rotate(int[] s, int rot, String dir) {
		if (dir.equals("left"))
			rot = (((s.length - rot) % s.length + s.length) % s.length);

		int[] s2 = new int[s.length];
		for (int i = 0; i < s.length; i++)
			s2[(i + rot) % s2.length] = s[i];
		return s2;
	}
}
