import heapq
from collections import defaultdict, namedtuple

# Define the tree node
class Node(namedtuple("Node", ["char", "freq"])):
    def __lt__(self, other):
        return self.freq < other.freq

def huffman_tree(frequencies):
    heap = [Node(char, freq) for char, freq in frequencies.items()]
    heapq.heapify(heap)
    while len(heap) > 1:
        left = heapq.heappop(heap)
        right = heapq.heappop(heap)
        heapq.heappush(heap, Node(left.char + right.char, left.freq + right.freq))
    return heap[0]

# Generate the huffman codes from the tree
def generate_huffman_codes(node, prefix="", codebook={}):
    if len(node.char) == 1:
        codebook[node.char] = prefix
    else:
        generate_huffman_codes(node.left, prefix + "0", codebook)
        generate_huffman_codes(node.right, prefix + "1", codebook)
    return codebook

# Frequency dictionary
frequencies = {
    'A': 80,
    'B': 10,
    'C': 15,
    'D': 30,
    'E': 45,
    '_': 120
}

# Create the huffman tree
root = huffman_tree(frequencies)

# Generate the huffman codes
codes = generate_huffman_codes(root)

codes
